<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CV;
use App\Services\GroqAIService;
use App\Services\PDFService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CVController extends Controller
{
    protected $aiService;
    protected $pdfService;

    public function __construct(GroqAIService $aiService, PDFService $pdfService)
    {
        $this->aiService = $aiService;
        $this->pdfService = $pdfService;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isi_cv' => 'required|string',
            'language' => 'nullable|string|in:id,en',
            'tone' => 'nullable|string|in:professional,creative,simple',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        // If the content is wrapped in HTML tags, extract the text
        $content = strip_tags($request->isi_cv);

        // If the content is empty after stripping tags, generate new content
        if (empty(trim($content)) || $content === 'Your CV content here') {
            $data = [
                'nama' => $user->nama,
                'email' => $user->email,
                'alamat' => $user->alamat,
                'tanggal_lahir' => $user->tanggal_lahir,
                'education' => $user->pendidikan()->get()->toArray(),
                'experience' => $user->pengalaman()->get()->toArray(),
                'skills' => $user->skills()->get()->toArray(),
                'language' => $request->language ?? 'id',
                'tone' => $request->tone ?? 'professional'
            ];

            $content = app(GroqAIService::class)->generateCV($data);
        }

        $cv = CV::updateOrCreate(
            ['user_id' => $user->id],
            ['isi_cv' => $content]
        );

        return response()->json([
            'status' => true,
            'message' => 'CV saved successfully',
            'data' => $cv
        ]);
    }

    public function show(Request $request)
    {
        $cv = $request->user()->cv;

        if (!$cv) {
            return response()->json([
                'status' => false,
                'message' => 'CV not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $cv
        ]);
    }

    public function generateWithAI(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'custom_prompt' => 'nullable|string|max:1000',
            'tone' => 'nullable|string|in:professional,creative,simple',
            'language' => 'nullable|string|in:id,en'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        $data = [
            'nama' => $user->nama,
            'email' => $user->email,
            'alamat' => $user->alamat,
            'tanggal_lahir' => $user->tanggal_lahir,
            'education' => $user->pendidikan()->get()->toArray(),
            'experience' => $user->pengalaman()->get()->toArray(),
            'skills' => $user->skills()->get()->toArray(),
            'custom_prompt' => $request->custom_prompt,
            'tone' => $request->tone ?? 'professional',
            'language' => $request->language ?? 'id'
        ];

        try {
            $generatedCV = $this->aiService->generateCV($data);

            if (!$generatedCV) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to generate CV'
                ], 500);
            }

            $cv = CV::updateOrCreate(
                ['user_id' => $user->id],
                ['isi_cv' => $generatedCV]
            );

            return response()->json([
                'status' => true,
                'message' => 'CV generated successfully',
                'data' => $cv
            ]);
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 429 ? 429 : 500;
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    public function exportPDF(Request $request)
    {
        $user = $request->user();
        $cv = $user->cv;

        if (!$cv) {
            return response()->json([
                'status' => false,
                'message' => 'CV not found'
            ], 404);
        }

        $data = [
            'cv' => $cv,
            'user' => $user,
            'education' => $user->pendidikan,
            'experience' => $user->pengalaman,
            'skills' => $user->skills,
            'language' => $request->language ?? 'id',
            'translations' => $this->getTranslations($request->language ?? 'id'),
        ];

        return $this->pdfService->generateCV($data, true);
    }

    public function previewPDF(Request $request)
    {
        $user = $request->user();
        $cv = $user->cv;

        if (!$cv) {
            return response()->json([
                'status' => false,
                'message' => 'CV not found'
            ], 404);
        }

        $data = [
            'cv' => $cv,
            'user' => $user,
            'education' => $user->pendidikan,
            'experience' => $user->pengalaman,
            'skills' => $user->skills,
            'language' => $request->language ?? 'id',
            'translations' => $this->getTranslations($request->language ?? 'id'),
        ];

        return $this->pdfService->generateCV($data, false);
    }

    private function getTranslations($language = 'id'): array
    {
        return $language === 'id' ? [
            'introduction' => 'Perkenalan',
            'education' => 'Pendidikan',
            'experience' => 'Pengalaman',
            'skills' => 'Keahlian',
            'present' => 'Sekarang',
            'gpa' => 'IPK'
        ] : [
            'introduction' => 'Introduction',
            'education' => 'Education',
            'experience' => 'Experience',
            'skills' => 'Skills',
            'present' => 'Present',
            'gpa' => 'GPA'
        ];
    }

    /**
     * Mencocokkan CV user dengan jobs di database menggunakan GroqAIService
     * @return \Illuminate\Http\JsonResponse
     */
    public function matchJobs(Request $request)
    {
        $user = $request->user();
        $cv = $user->cv;
        if (!$cv) {
            return response()->json([
                'status' => false,
                'message' => 'CV tidak ditemukan'
            ], 404);
        }
        // Ambil data CV dan jobs
        $cvData = [
            'nama' => $user->nama,
            'email' => $user->email,
            'alamat' => $user->alamat,
            'tanggal_lahir' => $user->tanggal_lahir,
            'education' => $user->pendidikan()->get()->toArray(),
            'experience' => $user->pengalaman()->get()->toArray(),
            'skills' => $user->skills()->get()->toArray(),
            'isi_cv' => $cv->isi_cv,
        ];
        $jobs = \App\Models\ScrapedJob::all(['id', 'position', 'company', 'location', 'date', 'salary', 'jobUrl', 'companyLogo', 'agoTime', 'keyword'])->toArray();
        $language = $request->language ?? 'id';
        // Panggil AI service
        $matchedIds = $this->aiService->matchJobsWithCV($cvData, $jobs, $language);
        return response()->json([
            'status' => true,
            'matched_job_ids' => $matchedIds
        ]);
    }

    /**
     * Upload CV (PDF/DOCX), analisis dengan AI, tanpa simpan ke database.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function analyzeUploadedCV(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:pdf,docx',
            'language' => 'nullable|string|in:id,en',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }
        $file = $request->file('file');
        $language = $request->language ?? 'id';
        $text = '';
        // Ekstrak teks dari file
        if ($file->getClientOriginalExtension() === 'pdf') {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $pdf->getText();
        } elseif ($file->getClientOriginalExtension() === 'docx') {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($file->getPathname());
            $text = '';
            foreach ($phpWord->getSections() as $section) {
                $elements = $section->getElements();
                foreach ($elements as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . "\n";
                    }
                }
            }
        }
        if (empty(trim($text))) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal ekstrak teks dari file CV.'
            ], 400);
        }
        // Kirim ke AI untuk analisis
        $analysis = $this->aiService->analyzeCVText($text, $language);
        // Simpan hasil analisis ke session (atau cache) untuk chat berikutnya
        session(['cv_analysis' => $analysis, 'cv_analysis_text' => $text, 'cv_analysis_language' => $language]);
        return response()->json([
            'status' => true,
            'message' => 'Analisis CV berhasil',
            'analysis' => $analysis
        ]);
    }

    /**
     * Chat dengan AI seputar hasil analisis CV yang diupload (topik relevan saja)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chatWithAIAboutCV(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
            'analysis' => 'required|string',
            'cvText' => 'required|string',
            'language' => 'nullable|string|in:id,en',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }
        $analysis = $request->analysis;
        $cvText = $request->cvText;
        $language = $request->language ?? 'id';
        $userMessage = $request->message;
        $aiReply = $this->aiService->chatAboutCV($cvText, $analysis, $userMessage, $language);
        return response()->json([
            'status' => true,
            'reply' => $aiReply
        ]);
    }
}