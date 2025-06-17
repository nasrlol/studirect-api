<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\LogService;
use App\Services\MailService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // momenteel hebben we 2 StudentController.php bestanden
    // elk met een functie index, eentje geeft een json response terug en
    // de andere geeft een view response terug
    // inefficient

    // kleine update over de vorige comment, het terug geven van een view is een
    // frontend iets en het zorgde alleen maar voor errors dus heb ik die er uit gehaald
    // in een vorige pull request

    public function index(): JsonResponse
    {
        $students = Student::cursorPaginate(15);

        /*
        if (request()->wantsJson()) {
        */

        // json voor json request
        return response()->json([
            'data' => $students
        ]);

        // return view voor het geval dat er een view wordt gevraagd
        /*
        return view('student.index', [
            'students' => $students
        ]);
    }
        */
        // code uitgecomment want het blijft maar een html view terug geven terwijl dat we de json nodig hebben
    }
    // het herkennen hiervan doet laravel automatisch, in geval van browser aanvraag -> view
    // anders krijg je een json (als de controller het vraagt he)

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
            'study_direction' => 'required|string|max:255', // Nu verplicht
            'graduation_track' => 'required|string|max:255', // Nu verplicht
            'interests' => 'nullable|string',
            'job_preferences' => 'nullable|string',
            'cv' => 'nullable|string',
            'profile_complete' => 'nullable|boolean',
        ]);

        // Standaardwaarden alleen voor optionele velden
        $defaults = [
            'interests' => 'Nog niet ingevuld',
            'job_preferences' => 'Nog niet ingevuld',
            'profile_complete' => false
        ];

        foreach ($defaults as $field => $value) {
            if (!isset($validated[$field])) {
                $validated[$field] = $value;
            }
        }

        $student = Student::create($validated);

        $logService->setLog("Student", $student->id,"Student created", "Student");
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
            return response()->json(['data' => $student]);
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
                'graduation_track' => 'required|string|max:255',
                'interests' => 'required|string',
                'job_preferences' => 'required|string',
                'cv' => 'nullable|string',
                'profile_complete' => 'boolean',
            ]);

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

    public function destroy(string $id, LogService $logService): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
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
                return response()->json(['message' => 'Student was already verified']);
            } else {
                $student->profile_complete = true;
                $student->save();
                // nu pas opgevallen dat de verandering nog moest opgeslagen worden
                return response()->json(['message' => 'Student now verified']);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Failed to find student'], 404);
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

            ];

            // filtreren op enkel de informatie dat meegegeven wordt
            $data = $request->only($fields);

            // het wachtwoord opnieuw hashen
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $student->update($data);
            $logService->setLog("Student", $student->id,"Student updated", "Student");

            return response()->json([
                'data' => $student,
                'message' => 'Student partially updated successfully',
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }
}
