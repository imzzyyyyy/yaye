<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;

class FacilityController extends Controller
{
    // Display a listing of the facilities
    public function index()
    {
        $facilities = Facility::all();
        return view('projectt.location.facilities.facility', compact('facilities'));
    }

    // Show the form for creating a new facility
    public function create()
    {
        return view('projectt.location.facilities.create');
    }

    // Store a newly created facility in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $facility = Facility::create($validated);

        return response()->json(['facility' => $facility], 201);
    }

    // Display the specified facility
    public function show($id)
    {
        $facility = Facility::find($id);

        if (!$facility) {
            return redirect()->route('facilities.index')->with('status', 'Facility not found');
        }

        return view('projectt.location.facilities.show', compact('facility'));
    }

    // Show the form for editing the specified facility
    public function edit($id)
    {
        $facility = Facility::find($id);

        if (!$facility) {
            return redirect()->route('facilities.index')->with('status', 'Facility not found');
        }

        return view('projectt.location.facilities.edit', compact('facility'));
    }

    // Update the specified facility in storage
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $facility = Facility::findOrFail($id);
        $facility->update($validated);

        return response()->json(['facility' => $facility]);
    }

    // Remove the specified facility from storage
    public function destroy($id)
    {
        $facility = Facility::find($id);

        if (!$facility) {
            return response()->json(['status' => 'error', 'message' => 'Facility not found'], 404);
        }

        $facility->delete();

        return response()->json(['status' => 'success']);
    }
}
