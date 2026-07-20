<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $coupons = Coupon::withCount('bookings')->paginate(10);
        return CouponResource::collection($coupons);
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'discount' => 'required|string|max:20',
            'type' => 'required|string|in:percentage,fixed',
            'description' => 'nullable|string|max:500',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date|after:now',
            'expires_at' => 'nullable|date|after:starts_at',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        
        if ($request->type === 'percentage' && !str_contains($request->discount, '%')) {
            $data['discount'] = $request->discount . '%';
        }

        $coupon = Coupon::create($data);

        return response()->json([
            'message' => 'Coupon created successfully',
            'coupon' => new CouponResource($coupon)
        ], 201);
    }

    public function show(Coupon $coupon)
    {
        if (Auth::user()->role !== 'admin') {
            return new CouponResource($coupon);
        }

        $coupon->loadCount('bookings');
        return new CouponResource($coupon);
    }

    public function update(Request $request, Coupon $coupon)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $request->validate([
            'code' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('coupons', 'code')->ignore($coupon->id),
            ],
            'discount' => 'sometimes|string|max:20',
            'type' => 'sometimes|string|in:percentage,fixed',
            'description' => 'nullable|string|max:500',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        if ($request->has('type') && $request->type === 'percentage' && $request->has('discount')) {
            if (!str_contains($request->discount, '%')) {
                $data['discount'] = $request->discount . '%';
            }
        }

        $coupon->update($data);

        return response()->json([
            'message' => 'Coupon updated successfully',
            'coupon' => new CouponResource($coupon)
        ]);
    }

    public function destroy(Coupon $coupon)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        if ($coupon->bookings()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete coupon because it has been used in bookings.'
            ], 422);
        }

        $coupon->delete();

        return response()->json(['message' => 'Coupon deleted successfully']);
    }

    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'total_price' => 'required|numeric|min:0',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json(['valid' => false, 'message' => 'Invalid coupon code'], 404);
        }

        if (!$coupon->is_active) {
            return response()->json(['valid' => false, 'message' => 'Coupon is not active'], 422);
        }

        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return response()->json(['valid' => false, 'message' => 'Coupon has expired'], 422);
        }

        if ($coupon->starts_at && now()->lt($coupon->starts_at)) {
            return response()->json(['valid' => false, 'message' => 'Coupon is not yet active'], 422);
        }

        if ($coupon->min_order_amount && $request->total_price < $coupon->min_order_amount) {
            return response()->json([
                'valid' => false,
                'message' => 'Minimum order amount is ' . $coupon->min_order_amount
            ], 422);
        }

        if ($coupon->usage_limit) {
            $usedCount = $coupon->bookings()->count();
            if ($usedCount >= $coupon->usage_limit) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Coupon usage limit has been reached'
                ], 422);
            }
        }

        if ($coupon->per_user_limit && $request->user_id) {
            $userUsedCount = $coupon->bookings()
                ->where('user_id', $request->user_id)
                ->count();
            
            if ($userUsedCount >= $coupon->per_user_limit) {
                return response()->json([
                    'valid' => false,
                    'message' => 'You have reached the maximum usage limit for this coupon'
                ], 422);
            }
        }

        $discountAmount = 0;
        $isPercentage = str_contains($coupon->discount, '%');

        if ($isPercentage) {
            $percent = (float) str_replace('%', '', $coupon->discount) / 100;
            $discountAmount = $request->total_price * $percent;
        } else {
            $discountAmount = (float) $coupon->discount;
        }

        if ($coupon->max_discount_amount && $discountAmount > $coupon->max_discount_amount) {
            $discountAmount = $coupon->max_discount_amount;
        }

        $finalPrice = max(0, $request->total_price - $discountAmount);

        return response()->json([
            'valid' => true,
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount' => $coupon->discount,
                'type' => $coupon->type,
                'description' => $coupon->description,
            ],
            'original_price' => $request->total_price,
            'discount_amount' => round($discountAmount, 2),
            'final_price' => round($finalPrice, 2),
        ]);
    }

    public function getActiveCoupons()
    {
        $coupons = Coupon::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->where(function ($query) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->select('id', 'code', 'discount', 'description', 'min_order_amount')
            ->get();

        return response()->json(['coupons' => $coupons]);
    }

    public function toggleStatus(Coupon $coupon)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        return response()->json([
            'message' => 'Coupon status updated successfully',
            'coupon' => new CouponResource($coupon)
        ]);
    }

    public function bulkDelete(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $request->validate([
            'coupon_ids' => 'required|array',
            'coupon_ids.*' => 'exists:coupons,id',
        ]);

        $couponsWithBookings = Coupon::whereIn('id', $request->coupon_ids)
            ->has('bookings')
            ->pluck('id');

        if ($couponsWithBookings->isNotEmpty()) {
            return response()->json([
                'message' => 'Some coupons have bookings and cannot be deleted',
                'coupon_ids_with_bookings' => $couponsWithBookings
            ], 422);
        }

        $deleted = Coupon::whereIn('id', $request->coupon_ids)->delete();

        return response()->json([
            'message' => $deleted . ' coupons deleted successfully'
        ]);
    }

    public function getStatistics()
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
        }

        $totalCoupons = Coupon::count();
        $activeCoupons = Coupon::where('is_active', true)->count();
        $expiredCoupons = Coupon::where('expires_at', '<', now())->count();
        $usedCoupons = Coupon::has('bookings')->count();

        $mostUsedCoupon = Coupon::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->first();

        return response()->json([
            'total_coupons' => $totalCoupons,
            'active_coupons' => $activeCoupons,
            'expired_coupons' => $expiredCoupons,
            'used_coupons' => $usedCoupons,
            'most_used_coupon' => $mostUsedCoupon ? [
                'code' => $mostUsedCoupon->code,
                'bookings_count' => $mostUsedCoupon->bookings_count,
            ] : null,
        ]);
    }
}