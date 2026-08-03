<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::with('city')->paginate(10);
        return view('admin.zones.index', compact('zones'));
    }

    public function create()
    {
        $cities = City::where('is_active', true)->get();
        return view('admin.zones.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255|unique:zones',
        ]);

        Zone::create([
            'city_id' => $request->city_id,
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone created successfully!');
    }

    public function edit(Zone $zone)
    {
        $cities = City::where('is_active', true)->get();
        return view('admin.zones.edit', compact('zone', 'cities'));
    }

    public function update(Request $request, Zone $zone)
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255|unique:zones,name,' . $zone->id,
        ]);

        $zone->update([
            'city_id' => $request->city_id,
            'name' => $request->name,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone updated successfully!');
    }

    public function destroy(Zone $zone)
    {
        $zone->delete();
        return redirect()->route('admin.zones.index')
            ->with('success', 'Zone deleted successfully!');
    }
}