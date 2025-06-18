<?php

namespace App\Http\Controllers\Api;

use App\Enums\LogLevel;
use App\Http\Controllers\Controller;
use App\Models\Connection;
use App\Services\LogService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ConnectionController extends Controller
{
    // GET /api/connections
    public function index(): JsonResponse
    {
        $connections = Connection::all();
        return response()->json(['data' => $connections]);
    }

    // POST /api/connections
    public function store(Request $request, LogService $logService): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'company_id' => 'required|integer|exists:companies,id',
            'status' => 'required|boolean', // bijvoorbeeld 'true' of 'false'
        ]);

        // Calculate skill match percentage
        $skillMatchPercentage = Connection::calculateSkillMatchPercentage(
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

    // GET /api/connections/{id}
    public function show(string $id): JsonResponse
    {
        try {
            $connection = Connection::findOrFail($id);
            return response()->json(['data' => $connection]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'connection niet gevonden'], 404);
        }
    }

    // PUT /api/connections/{id}
    public function update(Request $request, string $id, LogService $logService): JsonResponse
    {
        try {
            $connection = Connection::findOrFail($id);

            $validated = $request->validate([
                'student_id' => 'required|integer|exists:students,id',
                'company_id' => 'required|integer|exists:companies,id',
                'status' => 'required|boolean',
            ]);

            // Update skill match percentage if student or company changed
            if ($connection->student_id != $validated['student_id'] || 
                $connection->company_id != $validated['company_id']) {
                $validated['skill_match_percentage'] = Connection::calculateSkillMatchPercentage(
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

    // DELETE /api/connections/{id}
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
