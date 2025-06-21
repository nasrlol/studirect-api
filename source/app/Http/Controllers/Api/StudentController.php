<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Student;
use App\Services\LogService;
use App\Services\MailService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        $students = Student::all();
        $this->authorize("viewAny", Admin::class);

        return response()->json([
            'data' => $students
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, LogService $logService, MailService $mailService): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:8',
            'study_direction' => 'required|string|max:255',
            'graduation_track' => 'required|integer|exists:diplomas,id',
            'interests' => 'nullable|string',
            'job_preferences' => 'nullable|string',
            'cv' => 'nullable|string|max:255',
            'profile_complete' => 'nullable|boolean',
            'profile_photo' => 'nullable|string|max:255',
        ]);

        // Standaardwaarden alleen voor optionele velden
        $defaults = [
            'interests' => 'Nog niet ingevuld',
            'job_preferences' => 'Nog niet ingevuld',
            'cv' => null,  // Default is null
            'profile_complete' => false,
            'profile_photo' => null,  // Default is null
        ];

        foreach ($defaults as $field => $value) {
            if (!isset($validated[$field])) {
                $validated[$field] = $value;
            }
        }

        $validated['password'] = Hash::make($validated['password']);

        $student = Student::create($validated);

        $logService->setLog("Student", $student->id, "Student created", "Student");
        $mailService->sendStudentVerification($student, $logService);

        return response()->json([
            'data' => $student,
            'message' => 'Student created successfully'
        ], 201);
    }

    /*
     * Display the specified resource.
     */

    public function show(string $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $this->authorize("view", $student);
            return response()->json(['data' => $student]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }

    public function destroy(string $id, LogService $logService): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);

            $this->authorize("delete", $student);
            $student->delete();

            $logService->setLog("Student", $student->id, "Student deleted", "Student");

            return response()->json([
                'message' => 'Student deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }

    public function verify(string $id)
    {
        try {
            $student = Student::findOrFail($id);

            if ($student->profile_complete) {
                return view('student.verified', [
                    'message' => 'Student was already verified.'
                ]);
            } else {
                $student->profile_complete = true;
                $student->save();

                return view('student.verified', [
                    'message' => 'Student is now verified.'
                ]);
            }
        } catch (ModelNotFoundException $e) {
            return view('student.verified', [
                'message' => 'Student could not be found.'
            ]);
        }
    }

    public function partialUpdate(Request $request, string $id, LogService $logService): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $fields = [
                'first_name',
                'last_name',
                'email',
                'password',
                'study_direction',
                'graduation_track',
                'interests',
                'job_preferences',
                'cv',
                'profile_complete',
                'profile_photo',
            ];

            // filtreren op enkel de informatie dat meegegeven wordt
            $data = $request->only($fields);

            // het wachtwoord opnieuw hashen
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $this->authorize("update", $student);
            $student->update($data);
            $logService->setLog("Student", $student->id, "Student updated", "Student");

            return response()->json([
                'data' => $student,
                'message' => 'Student partially updated successfully',
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, LogService $logService): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email,' . $student->id,
                'password' => 'required|string|min:8',
                'study_direction' => 'required|string|max:255',
                'graduation_track' => 'required|integer|exists:diplomas,id',
                'interests' => 'required|string',
                'job_preferences' => 'required|string',
                'cv' => 'nullable|string|max:255',
                'profile_complete' => 'boolean',
                'profile_photo' => 'nullable|string|max:255',
            ]);

            $validated['password'] = Hash::make($validated['password']);

            $this->authorize("update", $student);
            $student->update($validated);

            $logService->setLog("Student", $student->id, "Student updated", "Student");

            return response()->json([
                'data' => $student,
                'message' => 'Student updated successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }
}
