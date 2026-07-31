<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlayGround;
use Illuminate\Http\Request;

class PlayGroundController extends Controller
{
    public function index(Request $request)
    {
        $query = PlayGround::query();

        // 1. البحث حسب المدينة
        if ($request->has('city') && $request->city != '') {
            $query->where('city', $request->city);
        }

        // 2. البحث حسب النوع (كرة قدم، سلة، إلخ)
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // 3. الفلترة حسب السعر (الحد الأدنى والحد الأقصى)
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price_per_hour', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price_per_hour', '<=', $request->max_price);
        }

        // إرجاع الملاعب المفلترة
        $playgrounds = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Playgrounds fetched successfully',
            'data' => $playgrounds
        ], 200);
    }
}
