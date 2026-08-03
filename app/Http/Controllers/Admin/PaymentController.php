<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('booking')->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function confirm(Payment $payment)
    {
        $payment->update([
            'status' => 'confirmed',
        ]);

        $payment->booking->update([
            'payment_status' => 'paid',
        ]);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment confirmed successfully!');
    }
}