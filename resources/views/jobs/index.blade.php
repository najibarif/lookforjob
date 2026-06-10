@extends('layouts.main')

@section('title', 'Cari Lowongan Kerja - Look For Job')
@section('meta_description', 'Temukan lowongan pekerjaan impian Anda secara instan dari berbagai lokasi di Indonesia dengan fitur pencarian kerja Look For Job.')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-10 text-center md:text-left">
        <h1 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">
            Cari Lowongan Kerja
        </h1>
        <p class="mt-3 text-lg text-slate-600">
            Temukan pekerjaan impian Anda. Masukkan kata kunci dan lokasi untuk mulai mencari.
        </p>
    </div>

    <!-- Search Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 mb-8">
        <form method="GET" action="{{ url('/jobs') }}" class="space-y-4 md:space-y-0 md:flex md:gap-4 md:items-end">
            <!-- Keyword Input -->
            <div class="flex-1">
                <label for="keyword" class="block text-sm font-bold text-slate-700 mb-1.5">Kata Kunci</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="keyword" 
                        id="keyword" 
                        class="block w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition text-sm" 
                        placeholder="Contoh: Frontend Developer, Designer, Project Manager..." 
                        value="{{ $keyword ?? '' }}"
                    >
                </div>
            </div>

            <!-- Location Input -->
            <div class="flex-1">
                <label for="location" class="block text-sm font-bold text-slate-700 mb-1.5">Lokasi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="location" 
                        id="location" 
                        class="block w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition text-sm" 
                        placeholder="Contoh: Jakarta, Surabaya, Remote..." 
                        value="{{ $location ?? '' }}"
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2 md:pt-0">
                <button 
                    type="submit" 
                    class="w-full md:w-auto inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 h-[42px]"
                >
                    Cari Pekerjaan
                </button>
            </div>
        </form>
    </div>

    <!-- Error Message -->
    @if (isset($error))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 flex items-start" role="alert">
            <svg class="w-5 h-5 text-red-500 mr-3 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="text-sm text-red-600 font-medium">
                {{ $error }}
            </div>
        </div>
    @endif

    <!-- Jobs Output Section -->
    @if (!empty($jobs) && count($jobs) > 0)
        <!-- Grid of Job Cards (Mobile Optimized) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($jobs as $index => $job)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 hover:shadow-md hover:border-slate-300 transition duration-200 flex flex-col justify-between">
                    <div>
                        <!-- Title & Company -->
                        <div class="mb-4">
                            <h2 class="text-lg font-bold text-slate-900 line-clamp-2 hover:text-indigo-600 transition">
                                <a href="{{ $job['url'] }}" target="_blank" rel="noopener noreferrer">
                                    {{ $job['title'] }}
                                </a>
                            </h2>
                            <p class="text-sm font-semibold text-indigo-600 mt-1">
                                {{ $job['company'] }}
                            </p>
                        </div>

                        <!-- Badges/Info -->
                        <div class="space-y-2 mb-6 text-sm text-slate-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                <span class="truncate">{{ $job['location'] }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Diposting: {{ $job['date_posted'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400 font-medium">#{{ $index + 1 }}</span>
                        <a 
                            href="{{ $job['url'] }}" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center px-4 py-2 border border-slate-200 text-xs font-semibold rounded-lg text-slate-700 bg-white hover:bg-slate-50 hover:border-slate-300 shadow-xs focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                        >
                            Lihat Lowongan
                            <svg class="w-3 h-3 ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-12 text-center shadow-sm">
            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-bold text-slate-900">Tidak ada lowongan ditemukan</h3>
            <p class="mt-2 text-sm text-slate-600 max-w-sm mx-auto leading-relaxed">
                Maaf, kami tidak dapat menemukan lowongan pekerjaan yang cocok. Coba cari dengan kata kunci atau lokasi yang berbeda.
            </p>
        </div>
    @endif
</div>
@endsection