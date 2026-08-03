<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PlayGround;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlayGroundController extends Controller
{
    public function availableHours(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $playground = PlayGround::findOrFail($id);
        $date = Carbon::parse($request->date)->toDateString();

        [$workStart, $workEnd] = explode('-', $playground->hourWork);

        $dayStart = Carbon::parse("{$date} {$workStart}");
        $dayEnd = Carbon::parse("{$date} {$workEnd}");

        if ($date == now()->toDateString() && now()->greaterThan($dayStart)) {
            $dayStart = now()->startOfHour();
        }

        $bookings = Booking::where('play_ground_id', $playground->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('start_date_time', $date)
            ->orderBy('start_date_time')
            ->get();

        $busySlots = $bookings->map(function ($booking) {
            return [
                'start' => Carbon::parse($booking->start_date_time)->format('H:i'),
                'end' => Carbon::parse($booking->end_date_time)->format('H:i'),
            ];
        })->values();

        $freeSlots = [];
        $cursor = $dayStart->copy();

        foreach ($bookings as $booking) {

            $bookingStart = Carbon::parse($booking->start_date_time);
            $bookingEnd = Carbon::parse($booking->end_date_time);

            if ($cursor->lt($bookingStart)) {
                $freeSlots[] = [
                    'start' => $cursor->format('H:i'),
                    'end' => $bookingStart->format('H:i'),
                ];
            }

            if ($cursor->lt($bookingEnd)) {
                $cursor = $bookingEnd->copy();
            }
        }

        if ($cursor->lt($dayEnd)) {
            $freeSlots[] = [
                'start' => $cursor->format('H:i'),
                'end' => $dayEnd->format('H:i'),
            ];
        }

        $freeSlots = collect($freeSlots)
            ->filter(function ($slot) use ($date, $playground) {

                $start = Carbon::parse("{$date} {$slot['start']}");
                $end = Carbon::parse("{$date} {$slot['end']}");

                return $start->diffInHours($end) >= $playground->minHours;
            })
            ->values();

        return response()->json([
            'message' => 'Available hours retrieved successfully.',
            'data' => [
                'play_ground_id' => $playground->id,
                'date' => $date,
                'work_hours' => [
                    'start' => $workStart,
                    'end' => $workEnd,
                ],
                'min_hours' => $playground->minHours,
                'max_hours' => $playground->maxHours,
                'busy_slots' => $busySlots,
                'free_slots' => $freeSlots,
            ]
        ]);
    }
    public function index(Request $request)
    {
        $query = PlayGround::query();
        if ($request->has('city') && $request->city != '') {
            $query->where('city', $request->city);
        }
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price_per_hour', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price_per_hour', '<=', $request->max_price);
        }
        $playgrounds = $query->get();


        return response()->json([
             'status' => true,
            'message' => 'Playgrounds fetched successfully',
            'data' => $playgrounds
        ], 200);
    }
}