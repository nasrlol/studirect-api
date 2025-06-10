<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\App;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $appointments = Appointment::all();
        return response()->json(['data' => $appointments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validate = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'company_id' => 'required|integer|exists:companies,id',
            // de exists:students,id kijkt na of dat de FK zich wel in de db bevindt
            'time_slot' => 'required|string|max:255',
        ]);

        $appointment = Appointment::create($validate);

        return response()->json([
            'data' => $appointment,
            'message' => 'Appointment created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $appointment = Appointment::findOrFail($id);
            return response()->json(['data' => $appointment]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $appointment = Appointment::findOrFail($id);
        $validated = $request->validate([
            'time_slot' => 'required|string|max:255',
            // afspraak verzetten = enkel tijdstip verzetten
        ]);

        $appointment->update($validated);
        return response()->json([
            'data' => $appointment,
            'message' => 'Appointment updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->delete();

            return response()->json([
                'message' => 'Appointment deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                    'message' => 'Appointment not found']
                , 404);
        }
    }
}
