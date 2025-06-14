<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Connection;
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
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'company_id' => 'required|integer|exists:companies,id',
            'status' => 'required|boolean', // bijvoorbeeld 'true' of 'false'
        ]);

        $connection = Connection::create($validated);

        $logger = new LogController();
        $logger->setLog("Student", "Connection created", "Connection", "Normal");

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
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $connection = Connection::findOrFail($id);

            $validated = $request->validate([
                'student_id' => 'required|integer|exists:students,id',
                'company_id' => 'required|integer|exists:companies,id',
                'status' => 'required|boolean',
            ]);

            $connection->update($validated);
            $logger = new LogController();
            $logger->setLog("Student", "Connection updated ", "Connection", "Normal");
            return response()->json([
                'data' => $connection,
                'message' => 'connection succesvol bijgewerkt'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'connection niet gevonden'], 404);
        }
    }

    // DELETE /api/connections/{id}
    public function destroy(string $id): JsonResponse
    {
        try {
            $connection = Connection::findOrFail($id);
            $connection->delete();

            $logger = new LogController();
            $logger->setLog("Student", "Connection deleted ", "Connection", "High");
            return response()->json([
                'message' => 'Connection deleted'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'connection niet gevonden'], 404);
        }
    }
}
