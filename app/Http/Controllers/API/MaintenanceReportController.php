<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceReport;
use App\Models\UsedPart;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MaintenanceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MaintenanceReport::with([
            'maintenanceSchedule', 
            'maintenanceSchedule.filter', 
            'technician',
            'technician.user',
            'usedParts',
            'usedParts.inventory'
        ]);
        
        // Filter by technician_id if provided
        if ($request->has('technician_id')) {
            $query->where('technician_id', $request->technician_id);
        }
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range if provided
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('service_date', [$request->start_date, $request->end_date]);
        }
        
        $reports = $query->get();
        return response()->json(['data' => $reports], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id' => 'required|exists:maintenance_schedules,id',
            'technician_id' => 'required|exists:technicians,id',
            'service_date' => 'required|date',
            'findings' => 'required|string',
            'actions_taken' => 'required|string',
            'recommendations' => 'nullable|string',
            'status' => 'required|in:draft,submitted,approved,rejected',
            'used_parts' => 'sometimes|array',
            'used_parts.*.inventory_id' => 'required|exists:inventory,id',
            'used_parts.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            
            // Create maintenance report
            $report = MaintenanceReport::create([
                'schedule_id' => $request->schedule_id,
                'technician_id' => $request->technician_id,
                'service_date' => $request->service_date,
                'findings' => $request->findings,
                'actions_taken' => $request->actions_taken,
                'recommendations' => $request->recommendations,
                'status' => $request->status,
            ]);
            
            // Add used parts if provided
            if ($request->has('used_parts') && is_array($request->used_parts)) {
                foreach ($request->used_parts as $part) {
                    // Create used part record
                    UsedPart::create([
                        'report_id' => $report->id,
                        'inventory_id' => $part['inventory_id'],
                        'quantity' => $part['quantity'],
                    ]);
                    
                    // Update inventory stock
                    $inventory = Inventory::findOrFail($part['inventory_id']);
                    $inventory->current_stock -= $part['quantity'];
                    $inventory->save();
                }
            }
            
            // Update maintenance schedule status if report is approved
            if ($request->status === 'approved') {
                $report->maintenanceSchedule->update(['status' => 'completed']);
            }
            
            DB::commit();
            
            return response()->json([
                'data' => $report->load(['usedParts', 'usedParts.inventory']), 
                'message' => 'Maintenance report created successfully'
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating maintenance report', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = MaintenanceReport::with([
            'maintenanceSchedule', 
            'maintenanceSchedule.filter', 
            'maintenanceSchedule.filter.site',
            'maintenanceSchedule.filter.site.client',
            'technician',
            'technician.user',
            'usedParts',
            'usedParts.inventory'
        ])->findOrFail($id);
        
        return response()->json(['data' => $report], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id' => 'sometimes|required|exists:maintenance_schedules,id',
            'technician_id' => 'sometimes|required|exists:technicians,id',
            'service_date' => 'sometimes|required|date',
            'findings' => 'sometimes|required|string',
            'actions_taken' => 'sometimes|required|string',
            'recommendations' => 'nullable|string',
            'status' => 'sometimes|required|in:draft,submitted,approved,rejected',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            
            $report = MaintenanceReport::findOrFail($id);
            $report->update($request->all());
            
            // Update maintenance schedule status if report is approved
            if ($request->has('status') && $request->status === 'approved') {
                $report->maintenanceSchedule->update(['status' => 'completed']);
            }
            
            DB::commit();
            
            return response()->json(['data' => $report, 'message' => 'Maintenance report updated successfully'], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating maintenance report', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            
            $report = MaintenanceReport::findOrFail($id);
            
            // Restore inventory quantities for used parts
            foreach ($report->usedParts as $usedPart) {
                $inventory = $usedPart->inventory;
                $inventory->current_stock += $usedPart->quantity;
                $inventory->save();
            }
            
            // Delete the report (will cascade delete used parts)
            $report->delete();
            
            DB::commit();
            
            return response()->json(['message' => 'Maintenance report deleted successfully'], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error deleting maintenance report', 'error' => $e->getMessage()], 500);
        }
    }
}

