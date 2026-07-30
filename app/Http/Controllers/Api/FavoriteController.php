<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFavoriteRequest;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(StoreFavoriteRequest $request){
        $data= $request->validated();
        $exists = Favorite::where('user_id', auth()->id())
            ->where('play_ground_id', $data['play_ground_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Playground is already in favorites.'
            ], 409);
        }

        $favorite = Favorite::create([
            'user_id' => auth()->id(),
            'play_ground_id' => $data['play_ground_id'],
        ]);

        return response()->json([
            'message' => 'Playground added to favorites successfully.',
            'data' => $favorite
        ], 201);
    }
    public function destroy(string $playground){
        $fav= Favorite::where('user_id', auth()->id())->where('play_ground_id', $playground);
        if (!$fav) {
            return response()->json([
                'message' => 'Favorite not found.'
            ], 404);
        }
        $fav->delete();
        return response()->json([
            'message' => 'Playground removed from favorites successfully.'
        ]);
    }
}
