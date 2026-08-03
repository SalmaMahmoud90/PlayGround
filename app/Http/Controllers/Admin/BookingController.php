<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'playground', 'coupon'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        // تحديث حالة الحجز
        $booking->update([
            'status' => 'confirmed',
        ]);

        // إذا طريقة الدفع كاش، يتحول لـ paid تلقائياً
        if ($booking->payment && $booking->payment->method === 'cash') {
            $booking->payment->update([
                'status' => 'confirmed',
            ]);
            $booking->update([
                'payment_status' => 'paid',
            ]);
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking confirmed successfully!');
    }

    public function reject(Booking $booking)
    {
        $booking->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking rejected successfully!');
    }

    public function complete(Booking $booking)
    {
        $booking->update([
            'status' => 'completed',
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking completed successfully!');
    }
}