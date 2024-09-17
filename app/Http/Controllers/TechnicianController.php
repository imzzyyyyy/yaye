<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    // Display a listing of the resource (Read).
    public function index()
    {
        $technicians = Technician::all();
        return view('projectt.techni.page', compact('technicians'));
    }

    public function create()
{
    return view('projectt.techni.create_technician');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|in:Active,Inactive',
    ]);

    $technician = Technician::create($validated);

    return response()->json(['technician' => $technician], 201);
}
public function show($id)
{
    $technician = Technician::find($id);

    if (!$technician) {
        return redirect()->route('technicians.index')->with('status', 'Technician not found');
    }

    return view('projectt.techni.show_technician', compact('technician'));
}

public function edit($id)
{
    $technician = Technician::find($id);

    if (!$technician) {
        return redirect()->route('technicians.index')->with('status', 'Technician not found');
    }

    return view('projectt.techni.edit_technician', compact('technician'));
}
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|in:Active,Inactive',
    ]);

    $technician = Technician::findOrFail($id);
    $technician->update($validated);

    return response()->json(['technician' => $technician]);
}
public function destroy($id)
{
    $technician = Technician::find($id);

    if (!$technician) {
        return response()->json(['status' => 'error', 'message' => 'Technician not found'], 404);
    }

    $technician->delete();

    return response()->json(['status' => 'success']);
}

}
