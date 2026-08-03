<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\PlayGround;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('playGround')
            ->get();

        return response()->json([
            'message' => 'Bookings retrieved successfully.',
            'data' => $bookings->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'play_ground_id' => $booking->play_ground_id,
                    'start_date_time' => $booking->start_date_time,
                    'end_date_time' => $booking->end_date_time,
                    'status' => $booking->status,
                    'payment_method' => $booking->payment_method,
                    'payment_status' => $booking->payment_status,
                    'total_price' => $booking->total_price,
                ];
            })
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $data = $request->validated();
        $playground = PlayGround::findOrFail($data['play_ground_id']);
        $start = Carbon::parse($data['start_date_time']);
        $end = Carbon::parse($data['end_date_time']);
        $hours = $start->diffInHours($end);
        if ($hours < $playground->minHours || $hours > $playground->maxHours) {
            return response()->json([
                'message' => 'Invalid booking duration.'
            ], 422);
        }
        $isBooked = Booking::where('play_ground_id', $playground->id)->whereIn('status', ['pending', 'confirmed'])->where(function ($query) use ($data) {
            $query->where('start_date_time', '<', $data['end_date_time'])->where('end_date_time', '>', $data['start_date_time']);
        })->exists();

        if ($isBooked) {
            return response()->json([
                'message' => 'The selected time slot is already booked.'
            ], 409);
        }
        $totalPrice = $hours * $playground->hourPrice;
        if (!empty($data['coupon_id'])) {
            $coupon = Coupon::find($data['coupon_id']);
            if ($coupon) {
                $totalPrice -= ($totalPrice * $coupon->discount / 100);
            }
        }
        $booking = Booking::create([
            'user_id'=>auth()->id(),
            'play_ground_id' => $playground->id,
            'coupon_id' => $data['coupon_id'] ?? null,
            'start_date_time' => $data['start_date_time'],
            'end_date_time' => $data['end_date_time'],
            'status' => 'pending',
	'payment_status' => 'pending',            
	'total_price' => $totalPrice,
        ]);
        return response()->json([
            'message' => 'Booking created successfully.',
            'data' => $booking
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with(['playGround', 'coupon'])->findOrFail($id);

        if ($booking->user_id != auth()->id()) {
            return response()->json([
                'message' => 'You are not authorized to view this booking.'
            ], 403);
        }

        return response()->json([
            'message' => 'Booking details retrieved successfully.',
            'data' => [
                'id' => $booking->id,
                'play_ground_id' => $booking->play_ground_id,
                'start_date_time' => $booking->start_date_time,
                'end_date_time' => $booking->end_date_time,
                'status' => $booking->status,
                'payment_method' => $booking->payment_method,
                'payment_status' => $booking->payment_status,
                'total_price' => $booking->total_price,
                'coupon_id' => $booking->coupon_id,
                'created_at' => $booking->created_at,
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book= Booking::findOrFail($id);
        if ($book->status == 'cancelled') {
            return response()->json([
                'message' => 'Booking is already cancelled.'
            ], 409);
        }
        if(Carbon::now()->diffInHours(Carbon::parse($book->start_date_time))<12){
            return response()->json([
            'message' => 'Booking can no longer be cancelled.'
        ], 409);
        }
        else{
            $book->status = 'cancelled';
            $book->cancelled_at = now();
            $book->save();
            return response()->json([
            'message' => 'Booking canceled successfully',
            'data' => [
                'id' => $book->id,
                'status' => $book->status,
                'cancelled_at' => $book->cancelled_at
            ]
        ], 200);
        }
    }

    public function pay(PaymentRequest $request, string $id){
        $book= Booking::findOrFail($id);
        $data= $request->validated();
        if ($book->user_id != auth()->id()) {
            return response()->json([
                'message' => 'You are not authorized to pay for this booking.'
            ], 403);
        }
        $paymentStatus = $data['payment_method'] == 'card'? 'paid': 'pending';

        $book->update([
            'payment_method' => $data['payment_method'],
            'payment_status' => $paymentStatus,
        ]);
        return response()->json([
            'message' => 'Payment request submitted successfully.',
            'data' => [
                'booking_id' => $book->id,
                'payment_method' => $book->payment_method,
                'payment_status' => $book->payment_status,
            ]   
        ]);
    }
}
