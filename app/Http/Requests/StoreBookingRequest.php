<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'play_ground_id' => 'required|exists:play_grounds,id',
            'start_date_time' => 'required|date|after:now',
            'end_date_time' => 'required|date|after:start_date_time',
            'payment_method' => 'required|in:cash,card',
            'coupon_id' => 'nullable|exists:coupons,id',
        ];
    }
}
