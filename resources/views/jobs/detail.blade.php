@extends('layouts.main')

@section('title', ($judul ?? 'Detail Pekerjaan') . ' - Look For Job')
@section('meta_description', 'Detail lowongan pekerjaan ' . ($judul ?? '') . ' di perusahaan ' . ($perusahaan ?? '') . ' - Look For Job.')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <!-- Back Navigation -->
    <div class="mb-6">
        <a href="{{ url('/jobs') }}" class="inline-flex items-center text-sm font-semibold text-slate-600 hover:text-indigo-600 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-sm">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke daftar pekerjaan
        </a>
    </div>

    <!-- Main Detail Card -->
    <article class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        <!-- Job Title & Company -->
        <header class="border-b border-slate-100 pb-6 mb-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                {{ $judul ?? '-' }}
            </h1>
            <p class="text-lg font-semibold text-indigo-600 mt-2">
                {{ $perusahaan ?? '-' }}
            </p>

            <!-- Info Badges -->
            <div class="flex flex-wrap gap-2.5 mt-4 text-xs font-semibold">
                @if (!empty($lokasi))
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-800">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                        {{ $lokasi }}
                    </span>
                @endif
                @if (!empty($gaji))
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-50 text-green-700 border border-green-200/50">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $gaji }}
                    </span>
                @endif
                @if (!empty($dipost))
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200/40">
                        <svg class="w-3.5 h-3.5 mr-1.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Diposting: {{ $dipost }}
                    </span>
                @endif
            </div>
        </header>

        <!-- Job Description Section -->
        <section class="mb-8">
            <h2 class="text-lg font-bold text-slate-900 mb-4">Deskripsi Pekerjaan</h2>
            @if(!empty($deskripsi))
                <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed">
                    {!! $deskripsi !!}
                </div>
            @else
                <p class="text-slate-500 italic text-sm">Deskripsi pekerjaan tidak tersedia.</p>
            @endif
        </section>

        <!-- Action Area -->
        <footer class="pt-6 border-t border-slate-100 space-y-4 sm:space-y-0 sm:flex sm:items-center sm:justify-between">
            <div class="flex flex-col sm:flex-row gap-3">
                @if(!empty($lamar_url))
                    <a 
                        href="{{ $lamar_url }}" 
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150"
                    >
                        Lamar Sekarang
                        <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                @endif
                
                <a 
                    href="{{ $url }}" 
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center justify-center px-5 py-3 border border-slate-200 text-sm font-semibold rounded-lg text-slate-700 bg-white hover:bg-slate-50 shadow-xs focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150"
                >
                    Lihat di Situs Asal
                    <svg class="w-4 h-4 ml-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>

            <!-- Share / Extra Info -->
            <p class="text-xs text-slate-400 font-medium">
                Pastikan Anda membaca deskripsi pekerjaan dengan teliti sebelum melamar.
            </p>
        </footer>
    </article>
</div>
@endsection