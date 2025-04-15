<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:Super Admin,Admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::with('company')->get();
        return response()->json($stores);
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
            'company_id' => 'required|exists:companies,id',
            'store_name' => 'required|string|max:255',
            'supervisor_name' => 'required|string|max:255',
            'supervisor_phone' => 'required|string',
            'supervisor_email' => 'required|email',
            'full_address' => 'required|string'
        ]);

        $store = Store::create($request->all());
        return response()->json($store, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        return response()->json($store->load(['company', 'maintenanceReports']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        $request->validate([
            'company_id' => 'sometimes|required|exists:companies,id',
            'store_name' => 'sometimes|required|string|max:255',
            'supervisor_name' => 'sometimes|required|string|max:255',
            'supervisor_phone' => 'sometimes|required|string',
            'supervisor_email' => 'sometimes|required|email',
            'full_address' => 'sometimes|required|string'
        ]);

        $store->update($request->all());
        return response()->json($store);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        $store->delete();
        return response()->json(null, 204);
    }

    public function generateQRCode(Store $store)
    {
        $qrCode = 'STORE-' . $store->id . '-' . time();
        $store->update(['qr_code' => $qrCode]);
        return response()->json(['qr_code' => $qrCode]);
    }
}
