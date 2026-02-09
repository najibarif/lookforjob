<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ScrapedJobFactory extends Factory
{
    public function definition(): array
    {
        $jobTitles = [
            'Frontend Developer', 'Backend Developer', 'Full Stack Developer', 'Mobile Developer', 
            'UI/UX Designer', 'DevOps Engineer', 'Data Scientist', 'Product Manager', 
            'QA Engineer', 'System Analyst', 'Digital Marketing Specialist', 'Content Writer',
            'HR Manager', 'Sales Executive', 'Business Development', 'Accountant'
        ];

        $companies = [
            'GoTo Group', 'Traveloka', 'Bukalapak', 'Shopee Indonesia', 'Bank BCA', 
            'Bank Mandiri', 'Telkom Indonesia', 'Ruangguru', 'Halodoc', 'Blibli', 
            'Astra International', 'Unilever Indonesia', 'Indofood', 'Pertamina'
        ];

        $locations = [
            'Jakarta', 'Surabaya', 'Bandung', 'Medan', 'Semarang', 
            'Makassar', 'Palembang', 'Tangerang', 'Depok', 'Bekasi',
            'Bogor', 'Denpasar', 'Malang', 'Yogyakarta', 'Balikpapan',
            'Pekanbaru', 'Batam', 'Surakarta', 'Manado', 'Padang', 'Jayapura'
        ];

        $title = fake()->randomElement($jobTitles);
        $location = fake()->randomElement($locations);

        // Generate a valid LinkedIn search URL using query parameters
        $encodedTitle = urlencode($title);
        $encodedLocation = urlencode($location . ', Indonesia');
        // Append a random number to ensure uniqueness for the database constraint
        $uniqueId = fake()->unique()->numberBetween(1000, 99999);
        
        $jobUrl = "https://www.linkedin.com/jobs/search?keywords={$encodedTitle}&location={$encodedLocation}&trackingId={$uniqueId}";

        return [
            'position' => $title,
            'company' => fake()->randomElement($companies),
            'location' => $location . ', Indonesia',
            'date' => fake()->dateTimeBetween('-1 month', 'now'),
            'salary' => 'IDR ' . fake()->numberBetween(5, 30) . '.000.000',
            'jobUrl' => $jobUrl,
            'companyLogo' => fake()->imageUrl(100, 100, 'business'),
            'agoTime' => fake()->randomElement(['1 hour ago', '2 days ago', '1 week ago', 'Just now']),
            'keyword' => $title, // Use title as keyword for filtering
        ];
    }
}
