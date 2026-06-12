<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;

class SalaryInsightsController extends Controller
{
    /**
     * Display the salary insights page
     */
    public function index()
    {
        return view('career-tools.salary-insights');
    }

    /**
     * Get salary data for a specific job role and location
     */
    public function getSalaryData(Request $request, \App\Services\CohereService $cohereService)
    {
        $validated = $request->validate([
            'job_title' => 'required|string',
            'location' => 'nullable|string',
        ]);

        try {
            $jobTitle = $validated['job_title'];
            $location = $validated['location'] ?? '';

            // Fetch real salary data from AI
            $salaryData = $cohereService->getSalaryInsights($jobTitle, $location);
            
            // Format to ensure all required fields exist
            $formattedData = [
                'job_title' => $jobTitle,
                'location' => $location ?: 'Indonesia',
                'average_salary' => $salaryData['average_salary'] ?? 'N/A',
                'salary_range' => [
                    'entry_level' => $salaryData['entry_level'] ?? 'N/A',
                    'mid_level' => $salaryData['average_salary'] ?? 'N/A',
                    'senior_level' => $salaryData['senior_level'] ?? 'N/A',
                ],
                'market_demand' => [
                    'high' => strtolower($salaryData['market_demand'] ?? '') === 'tinggi' ? 80 : 40,
                    'medium' => strtolower($salaryData['market_demand'] ?? '') === 'sedang' ? 60 : 30,
                    'low' => strtolower($salaryData['market_demand'] ?? '') === 'rendah' ? 80 : 20,
                ],
                'top_skills' => $salaryData['top_skills'] ?? ['Communication', 'Teamwork'],
                'job_growth' => 'Berdasarkan tren AI',
            ];

            return response()->json([
                'success' => true,
                'data' => $formattedData,
            ]);
        } catch (\Exception $e) {
            \Log::error('Cohere API Error: ' . $e->getMessage());
            
            // Fallback to static calculation if AI fails
            $jobTitle = $validated['job_title'];
            $averageSalary = $this->calculateAverageSalary($jobTitle);
            $salaryRange = $this->getSalaryRange($jobTitle);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'job_title' => $jobTitle,
                    'location' => $validated['location'] ?? 'Indonesia',
                    'average_salary' => $averageSalary,
                    'salary_range' => [
                        'entry_level' => $salaryRange['entry_level'],
                        'mid_level' => $salaryRange['mid_level'],
                        'senior_level' => $salaryRange['senior_level'],
                    ],
                    'market_demand' => [
                        'high' => 80,
                        'medium' => 15,
                        'low' => 5,
                    ],
                    'top_skills' => ['Communication', 'Problem Solving', 'Teamwork', 'Adaptability', 'Leadership'],
                    'job_growth' => '+15% (Estimasi)',
                ]
            ]);
        }
    }

    /**
     * Calculate average salary based on job title
     */
    private function calculateAverageSalary($jobTitle)
    {
        $salaries = [
            'developer' => 'Rp 80 Juta - Rp 150 Juta',
            'designer' => 'Rp 60 Juta - Rp 120 Juta',
            'manager' => 'Rp 100 Juta - Rp 200 Juta',
            'data scientist' => 'Rp 90 Juta - Rp 180 Juta',
            'product manager' => 'Rp 85 Juta - Rp 170 Juta',
        ];

        $keyword = strtolower($jobTitle);
        foreach ($salaries as $title => $salary) {
            if (strpos($keyword, $title) !== false) {
                return $salary;
            }
        }

        return 'Rp 60 Juta - Rp 120 Juta';
    }

    /**
     * Get salary range
     */
    private function getSalaryRange($jobTitle)
    {
        return [
            'entry_level' => 'Rp 40 Juta - Rp 60 Juta',
            'mid_level' => 'Rp 60 Juta - Rp 120 Juta',
            'senior_level' => 'Rp 120 Juta - Rp 250 Juta+',
        ];
    }

    /**
     * Get market demand
     */
    private function getMarketDemand($jobTitle)
    {
        return [
            'high' => 65,
            'medium' => 30,
            'low' => 5,
        ];
    }

    /**
     * Get top skills for the job
     */
    private function getTopSkills($jobTitle)
    {
        $skills = [
            'developer' => ['JavaScript', 'React', 'Node.js', 'TypeScript', 'REST APIs'],
            'designer' => ['Figma', 'Adobe XD', 'UI/UX Design', 'Prototyping', 'User Research'],
            'data scientist' => ['Python', 'SQL', 'Machine Learning', 'Data Analysis', 'Statistical Analysis'],
        ];

        $keyword = strtolower($jobTitle);
        foreach ($skills as $title => $skillList) {
            if (strpos($keyword, $title) !== false) {
                return $skillList;
            }
        }

        return ['Communication', 'Problem Solving', 'Leadership', 'Teamwork'];
    }
}
