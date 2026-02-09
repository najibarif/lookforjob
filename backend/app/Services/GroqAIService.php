<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GroqAIService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';
    protected $model = 'llama-3.3-70b-versatile'; // Updated to current available model

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
    }

    public function generateCV(array $data)
    {
        $prompt = $this->buildCVPrompt($data);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->baseUrl, [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.7
                ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'] ?? null;
        }

        \Log::error('Groq API Error: ' . $response->body());
        return null; // Controller handles null as error, or we could throw exception
    }

    private function buildCVPrompt(array $data): string
    {
        $isIndonesian = ($data['language'] ?? 'id') === 'id';
        $tone = $data['tone'] ?? 'professional';

        // Build introduction prompt based on education and experience
        $introPrompt = $isIndonesian ?
            "Buatkan paragraf maksimal 50-75 kata perkenalan profesional untuk CV. " .
            "Gabungkan latar belakang pendidikan dan pengalaman kerja. " .
            "Fokus pada pencapaian dan tujuan karir. Gunakan bahasa yang formal dan profesional. " .
            "HANYA berikan teks paragrafnya saja, tanpa pembuka atau penutup lain." :
            "Create a professional introduction paragraph (50-75 words) for a CV. " .
            "Combine educational background and work experience. " .
            "Focus on achievements and career objectives. Use formal and professional language. " .
            "ONLY provide the paragraph text, without any other opening or closing remarks.";

        $basePrompt = $introPrompt . "\n\n";
        $basePrompt .= "Data:\n";
        $basePrompt .= "Name: {$data['nama']}\n";
        $basePrompt .= "Education:\n" . $this->formatEducation($data['education']) . "\n\n";
        $basePrompt .= "Experience:\n" . $this->formatExperience($data['experience']) . "\n\n";
        $basePrompt .= "Skills:\n" . $this->formatSkills($data['skills']) . "\n\n";

        // Add custom prompt if provided
        if (isset($data['custom_prompt']) && !empty($data['custom_prompt'])) {
            $basePrompt .= "Additional User Instructions:\n{$data['custom_prompt']}\n\n";
        }

        // Add tone instruction
        $basePrompt .= "Tone: " . match ($tone) {
            'creative' => $isIndonesian ? "Kreatif dan menarik" : "Creative and engaging",
            'simple' => $isIndonesian ? "Sederhana, langsung, mudah dipahami" : "Simple, straightforward, easy to understand",
            default => $isIndonesian ? "Profesional, formal, berwibawa" : "Professional, formal, authoritative"
        } . "\n";

        return $basePrompt;
    }

    private function formatEducation(array $education): string
    {
        return collect($education)->map(function ($edu) {
            return "- {$edu['jenjang']} in {$edu['jurusan']} at {$edu['institusi']}\n" .
                "  {$edu['tanggal_mulai']} - {$edu['tanggal_akhir']}\n" .
                "  Location: {$edu['lokasi']}\n" .
                "  GPA: {$edu['ipk']}\n" .
                "  {$edu['deskripsi']}";
        })->implode("\n\n");
    }

    private function formatExperience(array $experience): string
    {
        return collect($experience)->map(function ($exp) {
            return "- {$exp['posisi']} at {$exp['institusi']}\n" .
                "  {$exp['tanggal_mulai']} - {$exp['tanggal_akhir']}\n" .
                "  Location: {$exp['lokasi']}\n" .
                "  {$exp['deskripsi']}";
        })->implode("\n\n");
    }

    private function formatSkills(array $skills): string
    {
        return collect($skills)->map(function ($skill) {
            return "- {$skill['nama_skill']} ({$skill['level']})";
        })->implode("\n");
    }

    public function matchJobsWithCV(array $cvData, array $jobsData, string $language = 'id')
    {
        $prompt = $this->buildMatchingPrompt($cvData, $jobsData, $language);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->baseUrl, [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.1, // Lower temperature for more deterministic/logical results
                    'response_format' => ['type' => 'json_object'] // Force JSON output if possible (Groq supports this on some models)
                ]);

        if ($response->successful()) {
            $text = $response->json()['choices'][0]['message']['content'] ?? null;
            if ($text) {
                // Try to parse JSON directly first
                $json = json_decode($text, true);
                if (isset($json['matched_ids']) && is_array($json['matched_ids'])) {
                    return $json['matched_ids'];
                }

                // Fallback: extract numbers
                preg_match_all('/\\b(\\d+)\\b/', $text, $matches);
                return $matches[1] ?? [];
            }
        }
        return [];
    }

    private function buildMatchingPrompt(array $cvData, array $jobsData, string $language = 'id'): string
    {
        $isIndonesian = $language === 'id';
        $intro = $isIndonesian ?
            "Cocokkan CV berikut dengan daftar pekerjaan di bawah ini. " :
            "Match the following CV with the list of jobs below. ";

        $instruction = $isIndonesian ?
            "Kembalikan response DALAM FORMAT JSON Object dengan key 'matched_ids' berisi array ID pekerjaan yang paling relevan (maksimal 5). Jangan ada teks lain." :
            "Return the response IN JSON Object format with key 'matched_ids' containing an array of the most relevant job IDs (max 5). No other text.";

        $prompt = $intro . $instruction . "\n\n";
        $prompt .= "CV:\n" . json_encode($cvData, JSON_PRETTY_PRINT);
        $prompt .= "\n\nJobs:\n" . json_encode($jobsData, JSON_PRETTY_PRINT);

        return $prompt;
    }

    public function analyzeCVText(string $cvText, string $language = 'id')
    {
        $prompt = $language === 'id'
            ? "Analisis CV berikut. Berikan output JSON dengan format: { 'score': 0-100, 'suggestions': ['saran 1', 'saran 2', ...] }. Pastikan saran, kritik, dan pujian membangun dalam bahasa Indonesia.\n\nCV:\n" . $cvText
            : "Analyze the following CV. Provide JSON output with format: { 'score': 0-100, 'suggestions': ['suggestion 1', 'suggestion 2', ...] }. Provide constructive feedback in English.\n\nCV:\n" . $cvText;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->baseUrl, [
                    'model' => $this->model,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.5,
                    'response_format' => ['type' => 'json_object']
                ]);

        if ($response->successful()) {
            $content = $response->json()['choices'][0]['message']['content'] ?? null;
            if ($content) {
                return json_decode($content, true);
            }
        }
        return null;
    }

    public function chatAboutCV(string $cvText, string $analysis, string $userMessage, string $language = 'id')
    {
        $systemPrompt = $language === 'id'
            ? "Kamu adalah asisten karir profesional. Jawab pertanyaan user berdasarkan CV mereka."
            : "You are a professional career assistant. Answer user questions based on their CV.";

        $userPrompt = $language === 'id'
            ? "Ini analisis CV saya: " . json_encode($analysis) . "\n\nIni isi CV saya:\n" . $cvText . "\n\nPertanyaan saya: " . $userMessage
            : "Here is my CV analysis: " . json_encode($analysis) . "\n\nHere is my CV content:\n" . $cvText . "\n\nMy question: " . $userMessage;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->baseUrl, [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt]
                    ]
                ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'] ?? null;
        }
        return null;
    }
}
