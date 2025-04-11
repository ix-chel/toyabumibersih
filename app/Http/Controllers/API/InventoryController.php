<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Inventory::query();
        
        // Filter by low stock if requested
        if ($request->has('low_stock') && $request->low_stock === 'true') {
            $query->whereRaw('current_stock <= reorder_level');
        }
        
        // Search by name or item code
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%");
            });
        }
        
        $inventory = $query->get();
        return response()->json(['data' => $inventory], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_code' => 'required|string|unique:inventory',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'current_stock' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            
            // Create inventory item
            $inventory = Inventory::create($request->all());
            
            // Create initial stock transaction if stock > 0
            if ($request->current_stock > 0) {
                InventoryTransaction::create([
                    'inventory_id' => $inventory->id,
                    'transaction_type' => 'initial',
                    'quantity' => $request->current_stock,
                    'reference' => 'Initial stock',
                    'user_id' => auth()->id(),
                    'transaction_date' => now(),
                ]);
            }
            
            DB::commit();
            
            return response()->json(['data' => $inventory, 'message' => 'Inventory item created successfully'], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating inventory item', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventory = Inventory::with('inventoryTransactions')->findOrFail($id);
        return response()->json(['data' => $inventory], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'item_code' => 'sometimes|required|string|unique:inventory,item_code,' . $id,
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'reorder_level' => 'sometimes|required|integer|min:1',
            'unit_price' => 'sometimes|required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $inventory = Inventory::findOrFail($id);
        $inventory->update($request->all());
        
        return response()->json(['data' => $inventory, 'message' => 'Inventory item updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = Inventory::findOrFail($id);
        
        // Check if inventory is in use
        if ($inventory->usedParts()->count() > 0) {
            return response()->json(['message' => 'Cannot delete inventory item that is in use'], 422);
        }
        
        $inventory->delete();
        
        return response()->json(['message' => 'Inventory item deleted successfully'], 200);
    }
    
    /**
     * Adjust inventory stock.
     */
    public function adjustStock(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'adjustment' => 'required|integer|not_in:0',
            'reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            
            $inventory = Inventory::findOrFail($id);
            
            // Ensure stock doesn't go negative
            if ($request->adjustment < 0 && abs($request->adjustment) > $inventory->current_stock) {
                return response()->json(['message' => 'Adjustment would result in negative stock'], 422);
            }
            
            // Update inventory stock
            $inventory->current_stock += $request->adjustment;
            $inventory->save();
            
            // Create transaction record
            InventoryTransaction::create([
                'inventory_id' => $inventory->id,
                'transaction_type' => $request->adjustment > 0 ? 'stock_in' : 'stock_out',
                'quantity' => abs($request->adjustment),
                'reference' => $request->reason,
                'user_id' => auth()->id(),
                'transaction_date' => now(),
            ]);
            
            DB::commit();
            
            return response()->json(['data' => $inventory, 'message' => 'Inventory stock adjusted successfully'], 200);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error adjusting inventory stock', 'error' => $e->getMessage()], 500);
        }
    }
}

