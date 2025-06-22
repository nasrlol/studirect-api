<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Skill;
use App\Models\Student;
use App\Policies\ConnectionService;
use App\Services\LogService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SkillController extends Controller
{
    /**
     * Display a listing of skills.
     */
    public function index(): JsonResponse
    {
        $skills = Cache::remember('skills.all', 60 * 60, function () {
            return Skill::all();
        });


        return response()->json([
            'data' => $skills
        ]);
    }

    /**
     * Display the specified skill.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $skill = Skill::findOrFail($id);
            return response()->json(['data' => $skill]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Skill not found'], 404);
        }
    }

    /**
     * Attach skills to a student.
     */
    public function attachToStudent(Request $request, string $id, LogService $logService): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);

            $validated = $request->validate([
                'skill_ids' => 'required|array',
                'skill_ids.*' => 'exists:skills,id'
            ]);

            $student->skills()->syncWithoutDetaching($validated['skill_ids']);

            $logService->setLog("Student", $student->id, "Skills added to student", "Student");

            return response()->json([
                'message' => 'Skills attached successfully',
                'data' => $student->load('skills')
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }

    /**
     * Detach a skill from a student.
     */
    public function detachFromStudent(string $id, string $skillId, LogService $logService): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $student->skills()->detach($skillId);

            $logService->setLog("Student", $student->id, "Skill removed from student", "Student");

            return response()->json([
                'message' => 'Skill detached successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student or skill not found'], 404);
        }
    }

    /**
     * Get all skills for a student.
     */
    public function getStudentSkills(string $id): JsonResponse
    {
        try {
            $student = Student::with('skills')->findOrFail($id);
            return response()->json([
                'data' => $student->skills
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student not found'], 404);
        }
    }

    /**
     * Attach skills to a company.
     */
    public function attachToCompany(Request $request, string $id, LogService $logService): JsonResponse
    {
        try {
            $company = Company::findOrFail($id);

            $validated = $request->validate([
                'skill_ids' => 'required|array',
                'skill_ids.*' => 'exists:skills,id'
            ]);

            $company->skills()->syncWithoutDetaching($validated['skill_ids']);

            $logService->setLog("Company", $company->id, "Skills added to company", "Company");

            return response()->json([
                'message' => 'Skills attached successfully',
                'data' => $company->load('skills')
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Company not found'], 404);
        }
    }

    /**
     * Detach a skill from a company.
     */
    public function detachFromCompany(string $id, string $skillId, LogService $logService): JsonResponse
    {
        try {
            $company = Company::findOrFail($id);
            $company->skills()->detach($skillId);

            $logService->setLog("Company", $company->id, "Skill removed from company", "Company");

            return response()->json([
                'message' => 'Skill detached successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Company or skill not found'], 404);
        }
    }

    /**
     * Get all skills for a company.
     */
    public function getCompanySkills(string $id): JsonResponse
    {
        try {
            $company = Company::with('skills')->findOrFail($id);
            return response()->json([
                'data' => $company->skills
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Company not found'], 404);
        }
    }

    /**
     * Calculate the skill match percentage between a student and company.
     */
    public function calculateMatch(string $studentId, string $companyId): JsonResponse
    {
        try {
            $matchPercentage = ConnectionService::calculateSkillMatchPercentage($studentId, $companyId);

            return response()->json([
                'data' => [
                    'student_id' => $studentId,
                    'company_id' => $companyId,
                    'match_percentage' => $matchPercentage
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Student or company not found'], 404);
        }
    }
}
