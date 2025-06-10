<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Connectie;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ConnectieController extends Controller
{
    // GET /api/connecties
    public function index(): JsonResponse
    {
        $connecties = Connectie::all();
        return response()->json(['data' => $connecties]);
    }

    // POST /api/connecties
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'company_id' => 'required|integer|exists:companies,id',
            'type' => 'required|string|max:255', // bijvoorbeeld 'match' of 'bericht'
        ]);

        $connectie = Connectie::create($validated);

        return response()->json([
            'data' => $connectie,
            'message' => 'Connectie succesvol aangemaakt'
        ], 201);
    }

    // GET /api/connecties/{id}
    public function show(string $id): JsonResponse
    {
        try {
            $connectie = Connectie::findOrFail($id);
            return response()->json(['data' => $connectie]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Connectie niet gevonden'], 404);
        }
    }

    // PUT /api/connecties/{id}
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $connectie = Connectie::findOrFail($id);

            $validated = $request->validate([
                'student_id' => 'required|integer|exists:students,id',
                'company_id' => 'required|integer|exists:companies,id',
                'type' => 'required|string|max:255',
            ]);

            $connectie->update($validated);

            return response()->json([
                'data' => $connectie,
                'message' => 'Connectie succesvol bijgewerkt'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Connectie niet gevonden'], 404);
        }
    }

    // DELETE /api/connecties/{id}
    public function destroy(string $id): JsonResponse
    {
        try {
            $connectie = Connectie::findOrFail($id);
            $connectie->delete();

            return response()->json([
                'message' => 'Connectie verwijderd'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Connectie niet gevonden'], 404);
        }
    }
}
