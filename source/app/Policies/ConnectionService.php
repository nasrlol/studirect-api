<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\Student;

class ConnectionService
{
    public static function calculateSkillMatchPercentage($studentId, $companyId): float
    {
        // Get the student and company with their skills
        $student = Student::with('skills')->findOrFail($studentId);
        $company = Company::with('skills')->findOrFail($companyId);

        // Get the skill IDs as collections
        $studentSkillIds = $student->skills->pluck('id');
        $companySkillIds = $company->skills->pluck('id');

        // If either has no skills, return 0%
        if ($studentSkillIds->isEmpty() || $companySkillIds->isEmpty()) {
            return 0;
        }

        // Count the matching skills
        $matchingSkillsCount = $studentSkillIds->intersect($companySkillIds)->count();

        // Calculate the total unique skills
        $totalUniqueSkills = $studentSkillIds->union($companySkillIds)->count();

        // Calculate the match percentage using Jaccard similarity coefficient
        $matchPercentage = ($matchingSkillsCount / $totalUniqueSkills) * 100;

        // Round to 2 decimal places
        return round($matchPercentage, 2);
    }
}
