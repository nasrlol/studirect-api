<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class StudentController extends Controller
{
    // momenteel hebben we 2 StudentController.php bestanden
    // elk met een functie index, eentje geeft een json response terug en
    // de andere geeft een view response terug
    // inefficient

    public function index(): View|JsonResponse
    {
        $students = Student::all();

        if (request()->wantsJson()) {
            // json voor json request
            return response()->json([
                'data' => $students
            ]);
        } else {
            // return view voor het geval dat er een view wordt gevraagd
            return view('student.index', [
                'students' => $students
            ]);
        }
    }
    // het herkennen hiervan doet laravel automatisch, in geval van browser aanvraag -> view
    // anders krijg je een json (als de controller het vraagt he)

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:8',
            'study_direction' => 'required|string|max:255',
            'graduation_track' => 'required|string|max:255',
            'interests' => 'required|string',
            'job_preferences' => 'required|string',
            'cv' => 'nullable|string',
            'profile_complete' => 'boolean',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'data' => $student,
            'message' => 'Student created successfully'
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            return response()->json(['data' => $student]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email' .$student->id,
                'password' => 'required|string|min:8',
                'study_direction' => 'required|string|max:255',
                'graduation_track' => 'required|string|max:255',
                'interests' => 'required|string',
                'job_preferences' => 'required|string',
                'cv' => 'nullable|string',
                'profile_complete' => 'boolean',
            ]);

            $student->update($validated);

            return response()->json([
                'data' => $student,
                'message' => 'Student updated successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();

            return response()->json([
                'message' => 'Student deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }
}
