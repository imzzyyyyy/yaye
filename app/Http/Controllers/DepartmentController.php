<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // Display a listing of the resource (Read).
    public function index()
    {
        $departments = Department::all();
        return view('projectt.depart.page', compact('departments'));
    }

    public function create()
    {
        return view('projectt.depart.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $department = Department::create($validated);

        return response()->json(['department' => $department], 201);
    }

    public function show($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return redirect()->route('departments.index')->with('status', 'Department not found');
        }

        return view('projectt.depart.show', compact('department'));
    }

    public function edit($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return redirect()->route('departments.index')->with('status', 'Department not found');
        }

        return view('projectt.depart.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $department = Department::findOrFail($id);
        $department->update($validated);

        return response()->json(['department' => $department]);
    }

    public function destroy($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json(['status' => 'error', 'message' => 'Department not found'], 404);
        }

        $department->delete();

        return response()->json(['status' => 'success']);
    }
}
