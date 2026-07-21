<?php
// app/Http/Requests/StoreCouponRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user() && auth()->user()->user_type === 'admin';
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:50|unique:coupons,code',
            'discount' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Coupon code is required.',
            'code.unique' => 'This coupon code already exists.',
            'discount.required' => 'Discount value is required.',
            'discount.numeric' => 'Discount must be a number.',
            'discount.min' => 'Discount must be at least 0.',
            'discount.max' => 'Discount cannot exceed 100.',
        ];
    }
}