<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $validated = $request->validated();
        $booking = Booking::find($validated['booking_id']);
        if ($booking->user_id != auth()->id()) {
            return response()->json([
                'message' => 'You are not allowed to review this booking.'
            ], 403);
        }
        if ($booking->status != 'confirmed') {
            return response()->json([
                'message' => 'You are not allowed to review this booking.'
            ], 403);
        }
        if (Review::where('booking_id', $booking->id)->exists()) {
            return response()->json([
                'message' => 'You have already reviewed this booking.'
            ], 409);
        }

        $review = Review::create([
            'user_id' => auth()->id(),
            'play_ground_id' => $booking->play_ground_id,
            'booking_id' => $booking->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'message' => 'Review added successfully.',
            'data' => [
                'id' => $review->id,
                'booking_id' => $review->booking_id,
                'rating' => $review->rating,
                'comment' => $review->comment,
            ]
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }
}
