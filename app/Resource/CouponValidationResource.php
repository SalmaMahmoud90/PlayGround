<?php
// app/Http/Resources/CouponValidationResource.php

namespace App\Http\Resources;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponValidationResource extends JsonResource
{
    private float $totalAmount;
    private float $discountAmount;
    private float $finalAmount;

    public function __construct(Coupon $coupon, float $totalAmount, float $discountAmount, float $finalAmount)
    {
        parent::__construct($coupon);
        $this->totalAmount = $totalAmount;
        $this->discountAmount = $discountAmount;
        $this->finalAmount = $finalAmount;
    }

    public function toArray(Request $request): array
    {
        return [
            'valid' => true,
            'coupon' => [
                'id' => $this->id,
                'code' => $this->code,
                'discount' => $this->discount,
            ],
            'original_price' => $this->totalAmount,
            'discount_amount' => $this->discountAmount,
            'final_price' => $this->finalAmount,
        ];
    }
}