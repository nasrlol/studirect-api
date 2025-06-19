<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Programming Languages
            ['name' => 'PHP', 'description' => 'PHP programming language'],
            ['name' => 'JavaScript', 'description' => 'JavaScript programming language'],
            ['name' => 'Python', 'description' => 'Python programming language'],
            ['name' => 'Java', 'description' => 'Java programming language'],
            ['name' => 'C#', 'description' => 'C# programming language'],
            ['name' => 'TypeScript', 'description' => 'TypeScript programming language'],
            ['name' => 'Swift', 'description' => 'Swift programming language for iOS'],
            ['name' => 'Kotlin', 'description' => 'Kotlin programming language for Android'],
            ['name' => 'Ruby', 'description' => 'Ruby programming language'],
            ['name' => 'Go', 'description' => 'Go programming language'],
            
            // Frameworks
            ['name' => 'Laravel', 'description' => 'PHP web framework'],
            ['name' => 'Vue.js', 'description' => 'JavaScript frontend framework'],
            ['name' => 'React', 'description' => 'JavaScript library for UI'],
            ['name' => 'Angular', 'description' => 'TypeScript-based web framework'],
            ['name' => 'Django', 'description' => 'Python web framework'],
            ['name' => 'Flask', 'description' => 'Python micro web framework'],
            ['name' => 'Spring', 'description' => 'Java framework'],
            ['name' => 'ASP.NET', 'description' => '.NET framework for web applications'],
            ['name' => 'Express.js', 'description' => 'Node.js web framework'],
            
            // Databases
            ['name' => 'MySQL', 'description' => 'Relational database management system'],
            ['name' => 'PostgreSQL', 'description' => 'Advanced open source relational database'],
            ['name' => 'MongoDB', 'description' => 'NoSQL document database'],
            ['name' => 'Redis', 'description' => 'In-memory data structure store'],
            ['name' => 'SQLite', 'description' => 'Lightweight disk-based database'],
            ['name' => 'Oracle', 'description' => 'Enterprise relational database'],
            ['name' => 'SQL Server', 'description' => 'Microsoft SQL Server'],
            
            // Tools & Technologies
            ['name' => 'Docker', 'description' => 'Container platform'],
            ['name' => 'Kubernetes', 'description' => 'Container orchestration'],
            ['name' => 'Git', 'description' => 'Version control system'],
            ['name' => 'CI/CD', 'description' => 'Continuous Integration/Continuous Deployment'],
            ['name' => 'AWS', 'description' => 'Amazon Web Services'],
            ['name' => 'Azure', 'description' => 'Microsoft cloud platform'],
            ['name' => 'Google Cloud', 'description' => 'Google Cloud Platform'],
            ['name' => 'RESTful APIs', 'description' => 'REST architecture for APIs'],
            ['name' => 'GraphQL', 'description' => 'Query language for APIs'],
            
            // Domains & Concepts
            ['name' => 'Machine Learning', 'description' => 'Subset of AI for pattern recognition'],
            ['name' => 'Data Science', 'description' => 'Extracting knowledge from data'],
            ['name' => 'DevOps', 'description' => 'Development and Operations integration'],
            ['name' => 'Cybersecurity', 'description' => 'Information security'],
            ['name' => 'UI/UX Design', 'description' => 'User Interface and Experience Design'],
            ['name' => 'Agile', 'description' => 'Agile software development methodology'],
            ['name' => 'Scrum', 'description' => 'Agile framework for managing work'],
            ['name' => 'Project Management', 'description' => 'Planning and organizing projects'],
            ['name' => 'SEO', 'description' => 'Search Engine Optimization'],
            ['name' => 'Digital Marketing', 'description' => 'Online marketing strategies'],
            
            // Soft Skills
            ['name' => 'Communication', 'description' => 'Effective verbal and written communication'],
            ['name' => 'Teamwork', 'description' => 'Working collaboratively in groups'],
            ['name' => 'Problem Solving', 'description' => 'Finding solutions to complex issues'],
            ['name' => 'Critical Thinking', 'description' => 'Objective analysis and evaluation'],
            ['name' => 'Leadership', 'description' => 'Leading and motivating teams'],
            ['name' => 'Time Management', 'description' => 'Efficient use of time'],
            ['name' => 'Adaptability', 'description' => 'Adjusting to new conditions'],
        ];
        
        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}