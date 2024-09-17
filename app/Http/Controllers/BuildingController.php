<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    // Display a listing of the resource (Read).
    public function index()
{
    $buildings = Building::all();
    return view('projectt.location.building.build', compact('buildings'));
}

public function create()
{
    return view('projectt.location.create_building');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|in:Active,Inactive',
    ]);

    $building = Building::create($validated);

    return response()->json(['building' => $building], 201);
}

public function show($id)
{
    $building = Building::find($id);

    if (!$building) {
        return redirect()->route('buildings.index')->with('status', 'Building not found');
    }

    return view('projectt.location.show_building', compact('building'));
}

public function edit($id)
{
    $building = Building::find($id);

    if (!$building) {
        return redirect()->route('buildings.index')->with('status', 'Building not found');
    }

    return view('projectt.location.edit_building', compact('building'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|in:Active,Inactive',
    ]);

    $building = Building::findOrFail($id);
    $building->update($validated);

    return response()->json(['building' => $building]);
}

public function destroy($id)
{
    $building = Building::find($id);

    if (!$building) {
        return response()->json(['status' => 'error', 'message' => 'Building not found'], 404);
    }

    $building->delete();

    return response()->json(['status' => 'success']);
}
}
