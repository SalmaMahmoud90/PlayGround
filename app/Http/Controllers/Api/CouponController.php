<?php
// app/Http/Controllers/Api/CouponController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Requests\ValidateCouponRequest;
use App\Http\Resources\CouponResource;
use App\Http\Resources\CouponValidationResource;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of coupons.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Coupon::withCount('bookings');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('code', 'like', "%{$search}%");
        }

        if ($request->has('min_discount')) {
            $query->where('discount', '>=', $request->min_discount);
        }

        if ($request->has('max_discount')) {
            $query->where('discount', '<=', $request->max_discount);
        }

        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        $coupons = $query->paginate($request->per_page ?? 15);

        return response()->json([
            'message' => 'Coupons retrieved successfully.',
            'data' => CouponResource::collection($coupons),
            'pagination' => [
                'current_page' => $coupons->currentPage(),
                'last_page' => $coupons->lastPage(),
                'per_page' => $coupons->perPage(),
                'total' => $coupons->total(),
            ]
        ]);
    }

    /**
     * Store a newly created coupon.
     */
    public function store(StoreCouponRequest $request): JsonResponse
    {
        $data = $request->validated();
        $coupon = Coupon::create($data);

        return response()->json([
            'message' => 'Coupon created successfully.',
            'data' => new CouponResource($coupon),
        ], 201);
    }

    /**
     * Display the specified coupon.
     */
    public function show($id): JsonResponse
    {
        $coupon = Coupon::withCount('bookings')->find($id);

        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found.'], 404);
        }

        return response()->json([
            'message' => 'Coupon retrieved successfully.',
            'data' => new CouponResource($coupon),
        ]);
    }

    /**
     * Update the specified coupon.
     */
    public function update(UpdateCouponRequest $request, $id): JsonResponse
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found.'], 404);
        }

        $data = $request->validated();
        $coupon->update($data);

        return response()->json([
            'message' => 'Coupon updated successfully.',
            'data' => new CouponResource($coupon->fresh()),
        ]);
    }

    /**
     * Remove the specified coupon.
     */
    public function destroy($id): JsonResponse
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found.'], 404);
        }

        if ($coupon->bookings()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete coupon that has been used in bookings.',
                'data' => [
                    'used_count' => $coupon->bookings()->count(),
                ]
            ], 409);
        }

        $coupon->delete();

        return response()->json([
            'message' => 'Coupon deleted successfully.'
        ]);
    }

    /**
     * Validate a coupon code.
     */
    public function validateCoupon(ValidateCouponRequest $request): JsonResponse
    {
        $data = $request->validated();
        $coupon = Coupon::where('code', $data['code'])->first();

        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid coupon code.',
            ], 404);
        }

        $totalAmount = $data['total_amount'];
        $discountAmount = ($coupon->discount / 100) * $totalAmount;
        $discountAmount = min($discountAmount, $totalAmount);
        $finalAmount = max(0, $totalAmount - $discountAmount);

        return response()->json([
            'message' => 'Coupon is valid.',
            'data' => new CouponValidationResource($coupon, $totalAmount, $discountAmount, $finalAmount),
        ]);
    }

    /**
     * Get coupon statistics for admin dashboard.
     */
    public function stats(): JsonResponse
    {
        if (auth()->user()->user_type !== 'admin') {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $totalCoupons = Coupon::count();
        $totalUsed = Coupon::withCount('bookings')->get()->sum('bookings_count');
        
        $mostUsed = Coupon::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->first();

        $highestDiscount = Coupon::orderBy('discount', 'desc')->first();

        $averageDiscount = Coupon::avg('discount') ?? 0;

        return response()->json([
            'message' => 'Coupon statistics retrieved successfully.',
            'data' => [
                'total_coupons' => $totalCoupons,
                'total_used' => $totalUsed,
                'average_discount' => round((float) $averageDiscount, 2),
                'most_used_coupon' => $mostUsed ? new CouponResource($mostUsed) : null,
                'highest_discount_coupon' => $highestDiscount ? new CouponResource($highestDiscount) : null,
                'usage_rate' => $totalCoupons > 0 ? round(($totalUsed / $totalCoupons) * 100, 2) : 0,
            ]
        ]);
    }

    /**
     * Bulk delete coupons.
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:coupons,id',
        ]);

        $ids = $request->ids;
        
        $usedCoupons = Coupon::whereIn('id', $ids)
            ->whereHas('bookings')
            ->count();

        if ($usedCoupons > 0) {
            return response()->json([
                'message' => 'Cannot delete coupons that have been used in bookings.',
                'data' => [
                    'used_coupons' => $usedCoupons,
                ]
            ], 409);
        }

        $deleted = Coupon::whereIn('id', $ids)->delete();

        return response()->json([
            'message' => "{$deleted} coupons deleted successfully.",
            'data' => [
                'deleted_count' => $deleted,
            ]
        ]);
    }

    /**
     * Generate a random coupon code.
     */
    public function generateCode(Request $request): JsonResponse
    {
        $length = $request->length ?? 8;
        $prefix = $request->prefix ?? '';
        $suffix = $request->suffix ?? '';

        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        }

        $code = $prefix . $randomString . $suffix;

        while (Coupon::where('code', $code)->exists()) {
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[random_int(0, strlen($characters) - 1)];
            }
            $code = $prefix . $randomString . $suffix;
        }

        return response()->json([
            'message' => 'Coupon code generated successfully.',
            'data' => [
                'code' => $code,
            ]
        ]);
    }

    /**
     * Get all available coupons (for dropdown/selection).
     */
    public function available(Request $request): JsonResponse
    {
        $coupons = Coupon::withCount('bookings')
            ->orderBy('code')
            ->get();

        return response()->json([
            'message' => 'Available coupons retrieved successfully.',
            'data' => CouponResource::collection($coupons),
        ]);
    }
}