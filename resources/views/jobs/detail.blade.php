@extends('layouts.main')

@section('title', 'Detail Lowongan - ' . $title)

@section('content')
@php
    $jobId = md5($title . $company);
    $isSaved = auth()->check() ? \App\Models\SavedJob::where('user_id', auth()->id())->where('job_id', $jobId)->exists() : false;
@endphp
<div class="bg-linear-canvas min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex text-sm text-linear-ink-subtle mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-linear-primary transition-colors">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 mx-1"></i>
                        <a href="{{ route('jobs') }}" class="hover:text-linear-primary transition-colors">Lowongan</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 mx-1"></i>
                        <span class="text-linear-ink font-medium line-clamp-1">{{ $title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header -->
                <div class="bg-linear-surface-1 rounded-3xl p-8 border border-linear-hairline relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-linear-primary/10 rounded-full blur-2xl opacity-60"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row md:items-start justify-between gap-6">
                        <div class="flex gap-6">
                            <div class="w-20 h-20 rounded-2xl bg-linear-surface-2 border border-linear-hairline flex items-center justify-center flex-shrink-0">
                                <i data-lucide="building" class="w-10 h-10 text-linear-primary"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h1 class="text-3xl font-extrabold text-linear-ink">{{ $title }}</h1>
                                    <span class="bg-linear-primary/10 text-linear-primary text-xs font-bold px-3 py-1 rounded-full border border-transparent">Baru</span>
                                </div>
                                <p class="text-lg text-linear-ink-muted font-medium mb-4">{{ $company }}</p>
                                
                                <div class="flex flex-wrap items-center gap-4 text-sm text-linear-ink-subtle">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-linear-ink-subtle"></i>
                                        {{ $location }}
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="briefcase" class="w-4 h-4 text-linear-ink-subtle"></i>
                                        Full Time
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="banknote" class="w-4 h-4 text-linear-ink-subtle"></i>
                                        Dirahasiakan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-linear-surface-1 rounded-3xl p-8 border border-linear-hairline">
                    <h2 class="text-xl font-bold text-linear-ink mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-linear-primary/10 flex items-center justify-center text-linear-primary">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </div>
                        Deskripsi Pekerjaan
                    </h2>
                    
                    <div class="prose prose-slate max-w-none prose-p:text-linear-ink-muted prose-p:leading-relaxed prose-li:text-linear-ink-muted prose-strong:text-linear-ink">
                        <p>Kami sedang mencari <strong>{{ $title }}</strong> yang bersemangat untuk bergabung dengan tim kami. Anda akan bertanggung jawab untuk membangun layanan yang menakjubkan dan memastikan pengalaman terbaik bagi pelanggan kami.</p>
                        
                        <h3 class="text-lg font-bold text-linear-ink mt-6 mb-3">Tanggung Jawab:</h3>
                        <ul class="space-y-2 list-disc pl-5">
                            <li>Mengembangkan dan memelihara fitur baru untuk produk kami.</li>
                            <li>Bekerja sama dengan tim untuk menerjemahkan desain menjadi kode atau hasil yang efisien.</li>
                            <li>Mengoptimalkan sistem untuk kecepatan dan skalabilitas maksimum.</li>
                            <li>Memastikan kualitas pekerjaan secara konsisten.</li>
                        </ul>
                        
                        <h3 class="text-lg font-bold text-linear-ink mt-6 mb-3">Persyaratan:</h3>
                        <ul class="space-y-2 list-disc pl-5">
                            <li>Pengalaman bekerja sebagai profesional di bidang ini.</li>
                            <li>Pemahaman mendalam tentang teknologi dan keterampilan yang relevan.</li>
                            <li>Mampu bekerja dalam tim dan berkomunikasi dengan baik.</li>
                        </ul>
                    </div>
                    
                    <h3 class="text-lg font-bold text-linear-ink mt-8 mb-4">Skill yang Dibutuhkan</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-4 py-2 bg-linear-surface-2 border border-linear-hairline rounded-xl text-sm font-medium text-linear-ink-subtle hover:border-linear-primary hover:bg-linear-primary/10 hover:text-linear-primary transition-colors cursor-pointer">Komunikasi</span>
                        <span class="px-4 py-2 bg-linear-surface-2 border border-linear-hairline rounded-xl text-sm font-medium text-linear-ink-subtle hover:border-linear-primary hover:bg-linear-primary/10 hover:text-linear-primary transition-colors cursor-pointer">Kerja Tim</span>
                        <span class="px-4 py-2 bg-linear-surface-2 border border-linear-hairline rounded-xl text-sm font-medium text-linear-ink-subtle hover:border-linear-primary hover:bg-linear-primary/10 hover:text-linear-primary transition-colors cursor-pointer">Inovatif</span>
                        <span class="px-4 py-2 bg-linear-surface-2 border border-linear-hairline rounded-xl text-sm font-medium text-linear-ink-subtle hover:border-linear-primary hover:bg-linear-primary/10 hover:text-linear-primary transition-colors cursor-pointer">Problem Solving</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6 lg:sticky lg:top-28">
                <!-- Apply Card -->
                <div class="bg-linear-surface-1 rounded-3xl p-6 border border-linear-primary/30">


                    <h3 class="font-bold text-linear-ink text-lg mb-2">Tertarik dengan posisi ini?</h3>
                    <p class="text-sm text-linear-ink-subtle mb-6">Lamar sekarang sebelum lowongan ditutup.</p>
                    
                    <form action="{{ route('jobs.apply') }}" method="POST">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ md5($title . $company) }}">
                        <input type="hidden" name="job_title" value="{{ $title }}">
                        <input type="hidden" name="company_name" value="{{ $company }}">
                        <input type="hidden" name="job_url" value="{{ $url ?? '#' }}">
                        
                        <button type="submit" @if($url) onclick="window.open('{{ $url }}', '_blank')" @endif class="w-full bg-linear-primary hover:bg-linear-primary-hover text-white font-semibold py-3.5 px-4 rounded-xl transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 mb-3">
                            Lamar Lowongan <i data-lucide="send" class="w-4 h-4"></i>
                        </button>
                    </form>
                    
                    <form action="{{ route('saved-jobs.toggle') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $jobId }}">
                        <input type="hidden" name="title" value="{{ $title }}">
                        <input type="hidden" name="company" value="{{ $company }}">
                        <input type="hidden" name="location" value="{{ $location }}">
                        <input type="hidden" name="url" value="{{ $url ?? '#' }}">
                        
                        <button type="submit" class="w-full bg-linear-canvas border-2 {{ $isSaved ? 'border-linear-primary bg-linear-primary/10 text-linear-primary' : 'border-linear-hairline hover:border-linear-primary hover:bg-linear-primary/10 text-linear-ink' }} font-semibold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                            {{ $isSaved ? 'Tersimpan' : 'Simpan Lowongan' }} <i data-lucide="bookmark" class="w-4 h-4 {{ $isSaved ? 'fill-current' : '' }}"></i>
                        </button>
                    </form>
                    
                    <div class="mt-6 pt-6 border-t border-linear-hairline">
                        <div class="flex items-center gap-3 text-sm text-linear-ink-subtle mb-3">
                            <i data-lucide="share-2" class="w-4 h-4"></i>
                            <span class="font-medium text-linear-ink">Bagikan lowongan ini</span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="copyLink()" class="w-10 h-10 rounded-xl bg-linear-surface-2 hover:bg-linear-primary/10 hover:text-linear-primary flex items-center justify-center transition-colors" title="Copy Link"><i data-lucide="link" class="w-4 h-4"></i></button>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 rounded-xl bg-linear-surface-2 hover:bg-blue-500/10 hover:text-blue-500 flex items-center justify-center transition-colors"><i data-lucide="facebook" class="w-4 h-4"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text=Lowongan {{ urlencode($title) }}" target="_blank" class="w-10 h-10 rounded-xl bg-linear-surface-2 hover:bg-sky-500/10 hover:text-sky-500 flex items-center justify-center transition-colors"><i data-lucide="twitter" class="w-4 h-4"></i></a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($title) }}" target="_blank" class="w-10 h-10 rounded-xl bg-linear-surface-2 hover:bg-blue-600/10 hover:text-blue-600 flex items-center justify-center transition-colors"><i data-lucide="linkedin" class="w-4 h-4"></i></a>
                        </div>
                        <script>
                            function copyLink() {
                                navigator.clipboard.writeText(window.location.href).then(() => {
                                    alert("Link disalin ke clipboard!");
                                });
                            }
                        </script>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="bg-linear-surface-1 rounded-3xl p-6 border border-linear-hairline">
                    <h3 class="font-bold text-linear-ink text-lg mb-4">Tentang Perusahaan</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 rounded-xl bg-linear-surface-2 border border-linear-hairline flex items-center justify-center flex-shrink-0">
                            <i data-lucide="building-2" class="w-6 h-6 text-linear-primary"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-linear-ink">{{ $company }}</h4>
                            <a href="#" class="text-sm text-linear-primary hover:text-linear-primary-hover hover:underline">Lihat profil lengkap</a>
                        </div>
                    </div>
                    <p class="text-sm text-linear-ink-muted leading-relaxed mb-4">
                        {{ $company }} adalah perusahaan yang terus berkembang dengan fokus pada inovasi.
                    </p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-sm text-linear-ink-muted">
                            <i data-lucide="users" class="w-4 h-4 text-linear-ink-subtle"></i> 50 - 500 Karyawan
                        </div>
                        <div class="flex items-center gap-3 text-sm text-linear-ink-muted">
                            <i data-lucide="globe" class="w-4 h-4 text-linear-ink-subtle"></i> www.perusahaan.com
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection