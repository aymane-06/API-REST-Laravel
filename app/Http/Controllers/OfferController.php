<?php

namespace App\Http\Controllers;

use App\Models\offer;
use App\Http\Requests\StoreofferRequest;
use App\Http\Requests\UpdateofferRequest;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = offer::all();
        return response()->json($offers);
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
    public function store(StoreofferRequest $request)
    {
        $validatedData = $request->all();
        
        // Convert skills to JSON if it's an array
        if (isset($validatedData['skills']) && is_array($validatedData['skills'])) {
            $validatedData['skills'] = json_encode($validatedData['skills']);
        }
        
        // Assign the authenticated user's ID
        $validatedData['user_id'] = '1';
        
        // Create the offer
        $offer = offer::create($validatedData);
        
        return response()->json([
            'message' => 'Offer created successfully',
            'data' => $offer
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateofferRequest $request, offer $offer)
    {
        $offer->title = $request->title;
        $offer->description = $request->description;
        $offer->location = $request->location;
        $offer->company_name = $request->company_name;
        $offer->salary = $request->salary;
        $offer->job_type = $request->job_type;
        $offer->experience_level = $request->experience_level;
        $offer->skills = $request->skills;
        $offer->application_deadline = $request->application_deadline;
        $offer->is_active = $request->is_active;
        $offer->save();
        return response()->json([
            'message' => 'Offer updated successfully',
            'data' => $offer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(offer $offer)
    {
        $offer->delete();
        return response()->json([
            'message' => 'Offer deleted successfully'
        ]);
    }
}
