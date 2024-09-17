<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Property;

class ItemController extends Controller
{
    /**
     * Display a listing of the items with their properties and parts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retrieve all items with their related properties and parts
        $items = Item::with('properties', 'parts')->get();
        
        // Render the view with the retrieved items
        return view('projectt.itemt.page', compact('items'));
    }

    /**
     * Store a newly created item along with its properties in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:items,name',
            'short_name' => 'nullable|string',
            'icon' => 'required|string',
            'properties' => 'array',
        ]);

        $item = Item::create([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'icon' => $request->icon,
        ]);

        if ($request->has('properties')) {
            foreach ($request->properties as $propertyData) {
                $property = Property::firstOrCreate(['label' => $propertyData['label']]);
                $item->properties()->attach($property->id, ['value' => $propertyData['value']]);
            }
        }

        return response()->json(['success' => true, 'id' => $item->id]);
    }

    /**
     * Update the specified item along with its properties in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:items,name,' . $id,
            'short_name' => 'nullable|string',
            'icon' => 'required|string',
            'properties' => 'array',
        ]);

        $item = Item::findOrFail($id);
        $item->update([
            'name' => $request->name,
            'short_name' => $request->short_name,
            'icon' => $request->icon,
        ]);

        // Update properties
        $item->properties()->detach();

        if ($request->has('properties')) {
            foreach ($request->properties as $propertyData) {
                $property = Property::firstOrCreate(['label' => $propertyData['label']]);
                $item->properties()->attach($property->id, ['value' => $propertyData['value']]);
            }
        }

        return response()->json(['success' => true]);
    }


}
