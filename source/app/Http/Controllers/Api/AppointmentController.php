<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\LogService;
use App\Services\MailService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    private function appointmentTimeOverlap(array $data, $id = null): bool
    {
        $query = Appointment::where('company_id', $data['company_id'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('time_start', [$data['time_start'], $data['time_end']])
                    ->orWhereBetween('time_end', [$data['time_start'], $data['time_end']])
                    ->orWhere(function ($query_) use ($data) {
                        $query_->where('time_start', '<=', $data['time_start'])
                            ->where('time_end', '>=', $data['time_end']);
                    });
            });

        if ($id) {
            $query->where('id', '!=', $id);
        }

        return $query->exists();
    }

    public function store(Request $request, MailService $mailService, LogService $logService): JsonResponse
    {
        $validate = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'company_id' => 'required|integer|exists:companies,id',
            // de "exists:student,id" id kijkt na of dat de FK zich wel in de db bevindt
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i'
        ]);

        $appointmentExists = Appointment::where('company_id', $validate['company_id'])
            ->where('time_start', $validate['time_start'])
            ->where('time_end', $validate['time_end'])
            ->exists();

        if ($appointmentExists)
        {
            return response()->json([
                'message' => 'That time slot is already being used'
            ]);
        }

        $appointment = Appointment::create($validate);

        $logService->setLog("student", $appointment->student_id, "appointment creation", " appointment");
        $mailService->sendAppointmentConfirmation($appointment, $logService);

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
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i'
        ]);

        $appointment->update($validated);
        return response()->json([
            'data' => $appointment,
            'message' => 'Appointment updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, LogService $logger): JsonResponse
    {
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->delete();

            $logger->setLog("Student", $appointment->student_id, "Appointment deleted", "Appointment");

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
