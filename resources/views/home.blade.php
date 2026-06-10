@extends('layouts.main')

@section('title', 'Look For Job - Temukan Karir Impian & Buat CV Profesional')
@section('meta_description', 'Temukan lowongan kerja impianmu dengan mudah dan buat CV profesional berbasis AI hanya dalam beberapa klik di Look For Job.')

@section('content')
<div class="relative overflow-hidden bg-slate-50 min-h-[calc(100vh-14rem)] flex flex-col justify-center py-12 sm:py-24">
    <!-- Background Gradient Accents -->
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-indigo-200/40 blur-3xl"></div>
        <div class="absolute top-1/2 -left-40 w-96 h-96 rounded-full bg-violet-200/30 blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Hero Header -->
        <div class="max-w-3xl mx-auto space-y-6">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-none">
                Selamat Datang di
                <span class="block mt-2 bg-gradient-to-r from-indigo-600 via-purple-600 to-violet-600 bg-clip-text text-transparent">
                    Look For Job
                </span>
            </h1>
            <p class="text-lg sm:text-xl text-slate-700 font-medium max-w-2xl mx-auto leading-relaxed">
                Platform cerdas untuk menemukan peluang karir terbaik dan menyusun CV profesional berbasis AI dalam sekejap.
            </p>
            
            <div class="pt-6 flex flex-wrap justify-center gap-4">
                @auth
                    <a href="{{ route('jobs') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        Cari Lowongan
                    </a>
                    <a href="{{ route('cv') }}" class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 text-base font-semibold rounded-lg text-slate-700 bg-white hover:bg-slate-50 shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        Generate CV
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        Mulai Cari Lowongan
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 border border-slate-300 text-base font-semibold rounded-lg text-slate-700 bg-white hover:bg-slate-50 shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        Mulai Buat CV
                    </a>
                @endauth
            </div>
        </div>

        <!-- Features Grid -->
        <div class="mt-20 max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 text-left">
            <!-- Feature 1: Search Jobs -->
            <div class="relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md hover:border-slate-300/80 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-3">Cari Lowongan Cepat</h2>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Akses ribuan data lowongan pekerjaan terkini dari berbagai industri dan kota di Indonesia secara langsung dan praktis.
                </p>
                <a href="{{ route('jobs') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-sm">
                    Mulai mencari
                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Feature 2: CV Generator -->
            <div class="relative bg-white/80 backdrop-blur-sm p-8 rounded-2xl border border-slate-200/60 shadow-sm hover:shadow-md hover:border-slate-300/80 transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600 mb-6 group-hover:bg-violet-600 group-hover:text-white transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-3">Generator CV AI</h2>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Masukkan detail pengalaman Anda secara kasual, dan AI kami akan menyusun resume terstruktur dan profesional dalam format HTML siap pakai.
                </p>
                <a href="{{ route('cv') }}" class="inline-flex items-center text-sm font-semibold text-violet-600 hover:text-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 rounded-sm">
                    Mulai buat CV
                    <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection