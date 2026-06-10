@extends('layouts.main')

@section('title', 'Generator CV AI - Look For Job')
@section('meta_description', 'Susun resume/CV profesional Anda dalam hitungan detik menggunakan teknologi AI Generator gratis dari Look For Job.')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">
            Generator CV AI
        </h1>
        <p class="mt-3 text-lg text-slate-600">
            Tulis profil, riwayat kerja, dan pendidikan Anda secara ringkas. Asisten AI kami akan mengubahnya menjadi CV HTML profesional.
        </p>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 gap-8">
        <!-- Input Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
            <form id="cvForm" class="space-y-6">
                <div>
                    <label for="user_input" class="block text-sm font-bold text-slate-700 mb-2">
                        Detail Pengalaman & Informasi Anda
                    </label>
                    <textarea 
                        class="block w-full border border-slate-300 rounded-xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition" 
                        id="user_input" 
                        name="user_input" 
                        rows="6" 
                        placeholder="Contoh: Nama saya Budi, Lulusan S1 Sistem Informasi. Pengalaman 2 tahun sebagai Frontend Developer menggunakan React dan Tailwind CSS. Pendidikan formal di Universitas Indonesia..."
                        required
                    ></textarea>
                    <p class="mt-2 text-xs text-slate-500 leading-normal">
                        Tip: Makin detail informasi yang Anda masukkan (nama, kontak, riwayat kerja, dll.), makin lengkap CV yang dihasilkan AI.
                    </p>
                </div>
                <div>
                    <button 
                        type="submit" 
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150"
                        id="generate-cv-btn"
                    >
                        <span>Generate CV Sekarang</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Output Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
            <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4 mb-6">
                Hasil Pembuatan CV
            </h2>
            <div id="cv-output-container" class="relative">
                <!-- Loader (hidden by default) -->
                <div id="cv-loader" class="hidden absolute inset-0 bg-white/70 backdrop-blur-xs flex flex-col items-center justify-center py-12 z-10" aria-live="polite">
                    <svg class="animate-spin h-10 w-10 text-indigo-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-slate-700">Menganalisis data & menyusun CV Anda...</span>
                </div>

                <!-- CV Result Box -->
                <div 
                    id="generated-cv" 
                    class="cv-output prose prose-slate max-w-none bg-slate-50 border border-slate-200 rounded-xl p-6 sm:p-8 min-h-[150px] text-slate-500 text-sm italic flex items-center justify-center"
                >
                    Belum ada CV yang dibuat. Masukkan detail Anda di atas dan klik tombol "Generate CV".
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('cvForm');
        const userInputEl = document.getElementById('user_input');
        const resultDiv = document.getElementById('generated-cv');
        const loader = document.getElementById('cv-loader');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const userInput = userInputEl.value.trim();
            
            if (!userInput) {
                resultDiv.className = "cv-output bg-red-50 border border-red-200 text-red-600 rounded-xl p-6 text-sm font-medium";
                resultDiv.innerHTML = "Silakan isi informasi Anda terlebih dahulu.";
                return;
            }

            // Show Loader and Reset output style
            loader.classList.remove('hidden');
            resultDiv.className = "cv-output prose prose-slate max-w-none bg-slate-50 border border-slate-200 rounded-xl p-6 sm:p-8 min-h-[150px]";
            resultDiv.innerHTML = "";

            try {
                const response = await fetch('/api/generate-cv', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ user_input: userInput }),
                });

                const data = await response.json();
                loader.classList.add('hidden');

                if (data.success) {
                    // Set class back to standard prose container for generated HTML
                    resultDiv.className = "cv-output prose prose-indigo max-w-none bg-white border border-slate-200/80 rounded-xl p-6 sm:p-8 shadow-inner";
                    resultDiv.innerHTML = data.cv;
                } else {
                    resultDiv.className = "cv-output bg-red-50 border border-red-200 text-red-600 rounded-xl p-6 text-sm font-medium";
                    resultDiv.innerHTML = data.error || 'Gagal generate CV';
                }
            } catch (err) {
                loader.classList.add('hidden');
                resultDiv.className = "cv-output bg-red-50 border border-red-200 text-red-600 rounded-xl p-6 text-sm font-medium";
                resultDiv.innerHTML = "Terjadi kesalahan pada server saat membuat CV. Silakan coba lagi.";
            }
        });
    });
</script>
@endsection
