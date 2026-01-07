<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Property::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:properties,code|max:50',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,reserved,sold',
        ]);

        $property = Property::create($validated);

        return response()->json($property, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return response()->json($property);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'code' => 'sometimes|string|unique:properties,code,' . $property->id . '|max:50',
            'price' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:available,reserved,sold',
        ]);

        $property->update($validated);

        return response()->json($property);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json(null, 204);
    }
}
