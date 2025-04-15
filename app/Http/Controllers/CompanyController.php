<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
        $companies = Company::all();
        return response()->json($companies);
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
            'name' => 'required|string|max:255',
            'supervisor_name' => 'required|string|max:255',
            'supervisor_phone' => 'required|string',
            'company_phone' => 'required|string',
            'company_email' => 'required|email',
            'supervisor_email' => 'required|email',
            'address' => 'required|string',
            'total_store' => 'required|integer|min:0',
            'status' => 'required|in:Active,Inactive',
            'joined_at' => 'required|date'
        ]);

        $company = Company::create($request->all());
        return response()->json($company, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return response()->json($company->load('stores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'supervisor_name' => 'sometimes|required|string|max:255',
            'supervisor_phone' => 'sometimes|required|string',
            'company_phone' => 'sometimes|required|string',
            'company_email' => 'sometimes|required|email',
            'supervisor_email' => 'sometimes|required|email',
            'address' => 'sometimes|required|string',
            'total_store' => 'sometimes|required|integer|min:0',
            'status' => 'sometimes|required|in:Active,Inactive',
            'joined_at' => 'sometimes|required|date'
        ]);

        $company->update($request->all());
        return response()->json($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json(null, 204);
    }
}
