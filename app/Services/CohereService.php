<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CohereService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.cohere.api_key');
    }

    public function generateCV($userInput)
    {
        // Hapus spasi berlebih
        $userInput = trim($userInput);
        if (empty($userInput)) {
            throw new \Exception('User input cannot be empty.');
        }

        // Siapkan prompt
        $prompt = <<<EOT
Kamu adalah seorang ahli HR dan pembuat CV profesional. Buatkan CV dalam bahasa Indonesia berdasarkan poin-poin informasi berikut. 
Tugasmu BUKAN sekadar menyalin ulang (copy-paste), melainkan memperbaiki tata bahasa, menguraikan tugas/pengalaman kerja menjadi kalimat atau poin-poin yang lebih profesional, berdampak (action-oriented), dan relevan untuk melamar kerja. Buatlah "Profil Singkat" yang menarik dan meyakinkan.

Informasi dari user:
$userInput

Aturan Format Output:
1. Tampilkan Nama di bagian paling atas dengan tag <h1>.
2. Lanjutkan dengan struktur heading <h2> berikut:
   - <h2>Profil Singkat</h2>
   - <h2>Pengalaman Kerja</h2>
   - <h2>Pendidikan</h2>
   - <h2>Keterampilan</h2>
   - <h2>Kontak</h2>
3. Formatkan hasilnya dalam HTML sederhana tanpa tag <html>, <head>, atau <body>. Hanya berikan isi kontennya saja.
4. Gunakan tag <ul> dan <li> untuk daftar pengalaman dan keterampilan. Gunakan <p> untuk paragraf profil. Gunakan <strong> untuk menekankan posisi atau institusi.
5. Jangan berikan teks pembuka/penutup seperti "Berikut adalah CV Anda". Jangan gunakan blok kode markdown (```html). Langsung mulai dengan tag <h1>.
EOT;

        $payload = [
            'model' => 'command-r-08-2024',
            'message' => $prompt,
            'max_tokens' => 1000,
            'temperature' => 0.7,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://api.cohere.ai/v1/chat', $payload);

        if (!$response->successful()) {
            $errorBody = $response->body();
            Log::error('Cohere API Error:', ['status' => $response->status(), 'body' => $errorBody]);
            throw new \Exception('Failed to generate CV from AI service.');
        }

        $result = $response->json();
        return $result['text'] ?? '';
    }

    public function processVoiceInterview($jobTitle, $chatHistory, $userMessage, $language = 'id-ID')
    {
        $isEnglish = ($language === 'en-US');
        $langContext = $isEnglish 
            ? "You are a professional Interviewer. You are interviewing a candidate for the \"$jobTitle\" position.\nThe candidate just said: \"$userMessage\"\n\nYour task:\n1. Provide a natural, supportive response that sounds like a real human conversation.\n2. Ask ONE relevant follow-up question.\n3. Keep your response short, maximum 2-3 sentences so it can be easily spoken by a voice AI.\n4. Never break character. Use professional but conversational English."
            : "Kamu adalah seorang Interviewer profesional. Anda sedang mewawancarai seorang kandidat untuk posisi \"$jobTitle\".\nKandidat baru saja mengatakan: \"$userMessage\"\n\nTugas Anda:\n1. Berikan tanggapan yang natural, suportif, dan terdengar seperti percakapan nyata.\n2. Ajukan SATU pertanyaan lanjutan (follow-up question) yang relevan.\n3. Jaga agar tanggapan Anda singkat, maksimal 2-3 kalimat agar mudah dibacakan oleh voice AI.\n4. Jangan pernah keluar dari karakter. Gunakan bahasa Indonesia yang santai tapi profesional.";

        $prompt = $langContext;

        $payload = [
            'model' => 'command-r-08-2024',
            'message' => $prompt,
            'chat_history' => $chatHistory,
            'max_tokens' => 300,
            'temperature' => 0.6,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://api.cohere.ai/v1/chat', $payload);

        if (!$response->successful()) {
            throw new \Exception('Failed to get interview response from AI.');
        }

        return $response->json();
    }

    public function getSalaryInsights($jobTitle, $location)
    {
        $locStr = $location ? $location : 'Indonesia';
        $prompt = <<<EOT
Berdasarkan data pasar tenaga kerja nyata dan terkini, berikan estimasi wawasan gaji untuk profesi "$jobTitle" di "$locStr".
Kembalikan HANYA respons berformat JSON murni tanpa markdown, tanpa teks pengantar atau penutup. 

Format JSON yang dibutuhkan:
{
  "average_salary": "Contoh: Rp 10.000.000",
  "entry_level": "Contoh: Rp 6.000.000 - Rp 8.000.000",
  "senior_level": "Contoh: Rp 15.000.000 - Rp 25.000.000",
  "market_demand": "Tinggi / Sedang / Rendah",
  "top_skills": ["Skill 1", "Skill 2", "Skill 3", "Skill 4", "Skill 5"]
}
EOT;

        $payload = [
            'model' => 'command-r-08-2024',
            'message' => $prompt,
            'max_tokens' => 500,
            'temperature' => 0.2,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://api.cohere.ai/v1/chat', $payload);

        if (!$response->successful()) {
            throw new \Exception('Failed to get salary insights from AI.');
        }

        $text = $response->json()['text'] ?? '';
        // Bersihkan markdown blok jika ada (```json ... ```)
        $text = preg_replace('/```json\s*/i', '', $text);
        $text = preg_replace('/```\s*/', '', $text);
        
        return json_decode(trim($text), true);
    }
}
