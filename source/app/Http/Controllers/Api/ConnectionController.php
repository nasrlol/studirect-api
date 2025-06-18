<?php

namespace App\Http\Controllers\Api;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\Connection;
use App\Services\ConnectionService;
use App\Services\LogService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    /**
     * Display a listing of connections.
     */
    public function index(): JsonResponse
    {
        $connections = Connection::all();
        return response()->json(['data' => $connections]);
    }

    /*
    * Create a new connection
    */
    public function store(Request $request, LogService $logService): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'company_id' => 'required|integer|exists:companies,id',
            'status' => 'required|boolean', // bijvoorbeeld 'true' of 'false'
            'skill_match_percentage' => 'nullable|numeric',
        ]);

        // Calculate skill match percentage
        $skillMatchPercentage = ConnectionService::calculateSkillMatchPercentage(
            $validated['student_id'],
            $validated['company_id']
        );

        // Add match percentage to validated data
        $validated['skill_match_percentage'] = $skillMatchPercentage;
        $connection = Connection::create($validated);

        $logService->setLog("Student", $connection->student_id, "Connection created", "Connection");

        return response()->json([
            'data' => $connection,
            'message' => 'connection succesvol aangemaakt'
        ], 201);
    }

    /*
    * Display a specific connection by ID
    */
    public function show(string $id): JsonResponse
    {
        try {
            $connection = Connection::findOrFail($id);
            return response()->json(['data' => $connection]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'connection niet gevonden'], 404);
        }
    }

    /*
     * Update a connection by ID
     */
    public function update(Request $request, string $id, LogService $logService): JsonResponse
    {
        try {
            $connection = Connection::findOrFail($id);

            $validated = $request->validate([
                'student_id' => 'required|integer|exists:students,id',
                'company_id' => 'required|integer|exists:companies,id',
                'status' => 'required|boolean',
            ]);

            // Bij het updaten van de connection, controleer of student_id of company_id is gewijzigd
            if ($connection->student_id != $validated['student_id'] ||
                $connection->company_id != $validated['company_id']) {
                $validated['skill_match_percentage'] = ConnectionService::calculateSkillMatchPercentage(
                    $validated['student_id'],
                    $validated['company_id']
                );
            }

            $connection->update($validated);
            $logService->setLog("Student", $connection->student_id, "Connection updated", "Connection");

            return response()->json([
                'data' => $connection,
                'message' => 'connection succesvol bijgewerkt'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'connection niet gevonden'], 404);
        }
    }

    /*
     * Delete a connection by ID
     */
    public function destroy(string $id, LogService $logService): JsonResponse
    {
        try {
            $connection = Connection::findOrFail($id);
            $connection->delete();

            $logService->setLog("Student", $connection->student_id, "Connection deleted ", "Connection", LogLevel::CRITICAL);
            return response()->json([
                'message' => 'Connection deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'connection niet gevonden'], 404);
        }
    }
}
