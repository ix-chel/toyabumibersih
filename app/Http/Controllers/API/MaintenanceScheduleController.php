<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaintenanceScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MaintenanceSchedule::with(['filter', 'filter.site', 'filter.site.client']);
        
        // Filter by filter_id if provided
        if ($request->has('filter_id')) {
            $query->where('filter_id', $request->filter_id);
        }
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('scheduled_date', [$request->start_date, $request->end_date]);
        }
        
        $schedules = $query->get();
        return response()->json(['data' => $schedules], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filter_id' => 'required|exists:filters,id',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'maintenance_type' => 'required|in:routine,repair,replacement,inspection',
            'status' => 'required|in:scheduled,completed,cancelled,rescheduled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $schedule = MaintenanceSchedule::create($request->all());
        return response()->json(['data' => $schedule, 'message' => 'Maintenance schedule created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = MaintenanceSchedule::with(['filter', 'filter.site', 'filter.site.client', 'maintenanceReport'])->findOrFail($id);
        return response()->json(['data' => $schedule], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'filter_id' => 'sometimes|required|exists:filters,id',
            'scheduled_date' => 'sometimes|required|date',
            'maintenance_type' => 'sometimes|required|in:routine,repair,replacement,inspection',
            'status' => 'sometimes|required|in:scheduled,completed,cancelled,rescheduled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $schedule = MaintenanceSchedule::findOrFail($id);
        $schedule->update($request->all());
        
        return response()->json(['data' => $schedule, 'message' => 'Maintenance schedule updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = MaintenanceSchedule::findOrFail($id);
        $schedule->delete();
        
        return response()->json(['message' => 'Maintenance schedule deleted successfully'], 200);
    }
}

