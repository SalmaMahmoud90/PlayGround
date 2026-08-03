<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Owner;
use App\Models\Playground;
use App\Models\Zone;
use Illuminate\Http\Request;

class PlaygroundController extends Controller
{
    public function index()
    {
        $playgrounds = Playground::with(['owner', 'city', 'zone'])->paginate(10);
        return view('admin.playgrounds.index', compact('playgrounds'));
    }

    public function create()
    {
        $owners = Owner::with('user')->get();
        $cities = City::where('is_active', true)->get();
        $zones = Zone::where('is_active', true)->get();
        return view('admin.playgrounds.create', compact('owners', 'cities', 'zones'));
    }

    /* public function store(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:football,basketball,tennis,volleyball,multi',
            'price_per_hour' => 'required|numeric|min:0',
            'min_booking_hours' => 'required|integer|min:1',
            'max_booking_hours' => 'required|integer|min:1|gte:min_booking_hours',
            'opening_time' => 'required',
            'closing_time' => 'required|after:opening_time',
            'description' => 'nullable|string',
            'location_url' => 'nullable|url',
        ]);

        Playground::create([
            'owner_id' => $request->owner_id,
            'city_id' => $request->city_id,
            'zone_id' => $request->zone_id,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'price_per_hour' => $request->price_per_hour,
            'min_booking_hours' => $request->min_booking_hours,
            'max_booking_hours' => $request->max_booking_hours,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'location_url' => $request->location_url,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.playgrounds.index')
            ->with('success', 'Playground created successfully!');
    } */
    public function store(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:football,basketball,tennis,volleyball,multi',
            'price_per_hour' => 'required|numeric|min:0',
            'min_booking_hours' => 'required|integer|min:1',
            'max_booking_hours' => 'required|integer|min:1|gte:min_booking_hours',
            'opening_time' => 'required',
            'closing_time' => 'required|after:opening_time',
            'description' => 'nullable|string',
            'location_url' => 'nullable|url',
        ]);

        Playground::create([
            // حقول API (جدول play_grounds)
            'location' => $request->location_url ?? 'N/A',
            'city' => $request->city_id,  // هنخزن الـ city_id مؤقتاً
            'type' => $request->type,
            'hourPrice' => $request->price_per_hour,
            'hourWork' => $request->opening_time . '-' . $request->closing_time,
            'minHours' => $request->min_booking_hours,
            'maxHours' => $request->max_booking_hours,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.playgrounds.index')
            ->with('success', 'Playground created successfully!');
    }
    public function edit(Playground $playground)
    {
        $owners = Owner::with('user')->get();
        $cities = City::where('is_active', true)->get();
        $zones = Zone::where('is_active', true)->get();
        return view('admin.playgrounds.edit', compact('playground', 'owners', 'cities', 'zones'));
    }

    public function update(Request $request, Playground $playground)
    {
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'city_id' => 'required|exists:cities,id',
            'zone_id' => 'required|exists:zones,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:football,basketball,tennis,volleyball,multi',
            'price_per_hour' => 'required|numeric|min:0',
            'min_booking_hours' => 'required|integer|min:1',
            'max_booking_hours' => 'required|integer|min:1|gte:min_booking_hours',
            'opening_time' => 'required',
            'closing_time' => 'required|after:opening_time',
            'description' => 'nullable|string',
            'location_url' => 'nullable|url',
        ]);

        $playground->update([
            'owner_id' => $request->owner_id,
            'city_id' => $request->city_id,
            'zone_id' => $request->zone_id,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'price_per_hour' => $request->price_per_hour,
            'min_booking_hours' => $request->min_booking_hours,
            'max_booking_hours' => $request->max_booking_hours,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'location_url' => $request->location_url,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.playgrounds.index')
            ->with('success', 'Playground updated successfully!');
    }

    public function destroy(Playground $playground)
    {
        $playground->delete();
        return redirect()->route('admin.playgrounds.index')
            ->with('success', 'Playground deleted successfully!');
    }
}