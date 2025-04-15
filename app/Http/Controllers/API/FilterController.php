<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Filter::with(['site', 'site.client']);
        
        // Filter by site if provided
        if ($request->has('site_id')) {
            $query->where('site_id', $request->site_id);
        }
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $filters = $query->get();
        return response()->json(['data' => $filters], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_id' => 'required|exists:sites,id',
            'serial_number' => 'required|string|unique:filters',
            'model' => 'required|string|max:255',
            'installation_date' => 'required|date',
            'warranty_expiry' => 'required|date|after:installation_date',
            'status' => 'required|in:active,inactive,maintenance,replaced',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $filter = Filter::create($request->all());
        return response()->json(['data' => $filter, 'message' => 'Filter created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $filter = Filter::with(['site', 'site.client', 'maintenanceSchedules'])->findOrFail($id);
        return response()->json(['data' => $filter], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'site_id' => 'sometimes|required|exists:sites,id',
            'serial_number' => 'sometimes|required|string|unique:filters,serial_number,' . $id,
            'model' => 'sometimes|required|string|max:255',
            'installation_date' => 'sometimes|required|date',
            'warranty_expiry' => 'sometimes|required|date|after:installation_date',
            'status' => 'sometimes|required|in:active,inactive,maintenance,replaced',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $filter = Filter::findOrFail($id);
        $filter->update($request->all());
        
        return response()->json(['data' => $filter, 'message' => 'Filter updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $filter = Filter::findOrFail($id);
        $filter->delete();
        
        return response()->json(['message' => 'Filter deleted successfully'], 200);
    }
}
