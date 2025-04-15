<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceReport;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:Super Admin,Admin,Teknisi')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = MaintenanceReport::with(['store', 'user', 'partsUsed', 'photos'])->get();
        return response()->json($reports);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'activity_type' => 'required|in:Instalasi,Pergantian,Perbaikan,Pemberhentian,Penambahan',
            'description' => 'nullable|string',
            'parts_used' => 'array',
            'parts_used.*.equipment_name' => 'required|string',
            'parts_used.*.quantity' => 'required|integer|min:1',
            'photos' => 'array',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $report = MaintenanceReport::create([
            'store_id' => $request->store_id,
            'user_id' => auth()->id(),
            'activity_type' => $request->activity_type,
            'description' => $request->description,
            'timestamp' => now()
        ]);

        if ($request->has('parts_used')) {
            foreach ($request->parts_used as $part) {
                $report->partsUsed()->create($part);
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('maintenance_photos', 'public');
                $report->photos()->create(['photo_path' => $path]);
            }
        }

        return response()->json($report->load(['store', 'user', 'partsUsed', 'photos']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceReport $maintenanceReport)
    {
        return response()->json($maintenanceReport->load(['store', 'user', 'partsUsed', 'photos']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaintenanceReport $maintenanceReport)
    {
        $request->validate([
            'activity_type' => 'sometimes|required|in:Instalasi,Pergantian,Perbaikan,Pemberhentian,Penambahan',
            'description' => 'nullable|string',
            'parts_used' => 'array',
            'parts_used.*.equipment_name' => 'required|string',
            'parts_used.*.quantity' => 'required|integer|min:1',
            'photos' => 'array',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $maintenanceReport->update($request->only(['activity_type', 'description']));

        if ($request->has('parts_used')) {
            $maintenanceReport->partsUsed()->delete();
            foreach ($request->parts_used as $part) {
                $maintenanceReport->partsUsed()->create($part);
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('maintenance_photos', 'public');
                $maintenanceReport->photos()->create(['photo_path' => $path]);
            }
        }

        return response()->json($maintenanceReport->load(['store', 'user', 'partsUsed', 'photos']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceReport $maintenanceReport)
    {
        $maintenanceReport->delete();
        return response()->json(null, 204);
    }
}
