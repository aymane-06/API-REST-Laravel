<?php

namespace App\Http\Controllers;

use App\Models\Competences;
use App\Http\Requests\StoreCompetencesRequest;
use App\Http\Requests\UpdateCompetencesRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompetencesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $competences = Competences::all();
        return response()->json(['data' => $competences], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $competence = Competences::create($validated);
        
        return response()->json([
            'message' => 'Competence created successfully',
            'data' => $competence
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Competences $competence): JsonResponse
    {
        return response()->json(['data' => $competence], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competences $competence): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $competence->update($validated);
        
        return response()->json([
            'message' => 'Competence updated successfully',
            'data' => $competence
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Competences $competence): JsonResponse
    {
        $competence->delete();
        
        return response()->json([
            'message' => 'Competence deleted successfully'
        ], 200);
    }

    /**
     * Attach competence to user
     */
    public function attachToUser(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'competence_id' => 'required|exists:competences,id',
        ]);

        $user = \App\Models\User::find($validated['user_id']);
        $competence = Competences::find($validated['competence_id']);
        
        $user->competences()->attach($competence);
        
        return response()->json([
            'message' => 'Competence attached to user successfully'
        ], 200);
    }

    /**
     * Detach competence from user
     */
    public function detachFromUser(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'competence_id' => 'required|exists:competences,id',
        ]);

        $user = \App\Models\User::find($validated['user_id']);
        $competence = Competences::find($validated['competence_id']);
        
        $user->competences()->detach($competence);
        
        return response()->json([
            'message' => 'Competence detached from user successfully'
        ], 200);
    }
}
