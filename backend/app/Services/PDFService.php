<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class PDFService
{
    public function generateCV(array $data, bool $download = true)
    {
        // Set default language to Indonesian if not specified
        $data['language'] = $data['language'] ?? 'id';
        
        // Add translations based on language
        $data['translations'] = $this->getTranslations($data['language']);
        
        $pdf = PDF::loadView('pdf.cv', $data);

        if ($download) {
            return $pdf->download('cv.pdf');
        }

        // For preview, return with inline display headers
        return $pdf->stream('cv.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="cv.pdf"'
        ]);
    }

    private function getTranslations(string $language): array
    {
        return $language === 'id' ? [
            'education' => 'Pendidikan',
            'experience' => 'Pengalaman Kerja',
            'skills' => 'Keahlian',
            'introduction' => 'Perkenalan',
            'additional_info' => 'Informasi Tambahan',
            'address' => 'Alamat',
            'birth_date' => 'Tanggal Lahir',
            'present' => 'Sekarang',
            'gpa' => 'IPK'
        ] : [
            'education' => 'Education',
            'experience' => 'Work Experience',
            'skills' => 'Skills',
            'introduction' => 'Introduction',
            'additional_info' => 'Additional Information',
            'address' => 'Address',
            'birth_date' => 'Date of Birth',
            'present' => 'Present',
            'gpa' => 'GPA'
        ];
    }
} 