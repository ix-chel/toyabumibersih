<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditTrail;

class AuditTrailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:Super Admin,Admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auditTrails = AuditTrail::with('user')->latest()->get();
        return response()->json($auditTrails);
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
            'action_description' => 'required|string'
        ]);

        $auditTrail = AuditTrail::create([
            'user_id' => auth()->id(),
            'action_description' => $request->action_description
        ]);

        return response()->json($auditTrail, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(AuditTrail $auditTrail)
    {
        return response()->json($auditTrail->load('user'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
