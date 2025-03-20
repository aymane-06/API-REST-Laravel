<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Offer;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // If query param 'offer_id' is provided, filter by offer
        if ($request->has('offer_id')) {
            $applications = Application::where('offer_id', $request->offer_id)
                ->with('user')
                ->paginate(10);
        } else {
            // Only show applications belonging to the authenticated user
            $applications = $user->applications()
                ->with('offer')
                ->paginate(10);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $applications
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        
        // Handle file uploads if present
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
            $validated['cv'] = $cvPath;
        }
        
        if ($request->hasFile('cover_letter')) {
            $coverLetterPath = $request->file('cover_letter')->store('cover_letters', 'public');
            $validated['cover_letter'] = $coverLetterPath;
        }
        
        // Add user_id to application
        $validated['user_id'] = $user->id;
        
        $application = Application::create($validated);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Application submitted successfully',
            'data' => $application
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        $user = Auth::user();
        
        // Check if user owns this application or owns the offer
        $offer = Offer::find($application->offer_id);
        
        if ($application->user_id != $user->id && $offer->user_id != $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }
        
        // Mark as read if employer is viewing
        if ($offer->user_id == $user->id && !$application->read_at) {
            $application->read_at = now();
            $application->save();
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $application->load(['user', 'offer'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $user = Auth::user();
        $offer = Offer::find($application->offer_id);
        
        // Only the employer of the offer can update application status
        if ($offer->user_id != $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $validated = $request->validated();
        
        $application->update($validated);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Application updated successfully',
            'data' => $application
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $user = Auth::user();
        
        // Check if user owns this application or owns the offer
        $offer = Offer::find($application->offer_id);
        
        if ($application->user_id != $user->id && $offer->user_id != $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }
        
        // Delete files if they exist
        if ($application->cv) {
            Storage::disk('public')->delete($application->cv);
        }
        
        if ($application->cover_letter) {
            Storage::disk('public')->delete($application->cover_letter);
        }
        
        $application->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Application deleted successfully'
        ]);
    }

    /**
     * Change application status (accept/reject).
     */
    public function changeStatus(Request $request, Application $application)
    {
        $user = Auth::user();
        $offer = Offer::find($application->offer_id);
        
        // Only the employer of the offer can change status
        if ($offer->user_id != $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $request->validate([
            'status' => 'required|in:rejected,hired'
        ]);
        
        if ($request->status === 'rejected') {
            $application->rejected_at = now();
            $application->is_active = false;
        }
        
        if ($request->status === 'hired') {
            $application->hired_at = now();
            $application->is_active = false;
        }
        
        $application->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Application status updated successfully',
            'data' => $application
        ]);
    }
}
