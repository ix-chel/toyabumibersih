<?php

namespace App\Http\Controllers;

use App\Models\FeedbackComplaint;
use Illuminate\Http\Request;

class FeedbackComplaintController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:Super Admin,Admin')->except(['store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = FeedbackComplaint::with('company')->get();
        return response()->json($feedbacks);
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
            'type' => 'required|in:Feedback,Complaint',
            'message' => 'required|string'
        ]);

        $feedback = FeedbackComplaint::create([
            'company_id' => $request->company_id,
            'type' => $request->type,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        // TODO: Implement notification to Admin & Super Admin

        return response()->json($feedback, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FeedbackComplaint $feedbackComplaint)
    {
        return response()->json($feedbackComplaint->load('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeedbackComplaint $feedbackComplaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeedbackComplaint $feedbackComplaint)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved'
        ]);

        $feedbackComplaint->update(['status' => $request->status]);
        return response()->json($feedbackComplaint);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeedbackComplaint $feedbackComplaint)
    {
        $feedbackComplaint->delete();
        return response()->json(null, 204);
    }
}
