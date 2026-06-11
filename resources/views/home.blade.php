@extends('layouts.main')

@section('title', 'Look For Job - Temukan Karier Impian Anda')

@section('content')
<!-- Hero Section -->
<section class="relative bg-linear-canvas pt-20 pb-32 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-linear-primary/10 border border-linear-primary/20 text-linear-primary text-sm font-medium mb-8">
                <span class="flex w-2 h-2 rounded-full bg-linear-primary animate-pulse"></span>
                Lebih dari 10.000+ lowongan aktif bulan ini
            </div>
            <h1 class="text-5xl md:text-6xl font-extrabold text-linear-ink tracking-tight mb-6 leading-tight">
                Temukan Karier Impian <br class="hidden md:block" />
                <span class="text-linear-primary">Masa Depan Anda</span>
            </h1>
            <p class="text-lg md:text-xl text-linear-ink-muted mb-10 max-w-2xl mx-auto leading-relaxed">
                Platform terpercaya yang menghubungkan talenta terbaik dengan perusahaan impian. Temukan peluang yang sesuai dengan potensi Anda.
            </p>

            <!-- Search Form -->
            <form action="{{ route('jobs') }}" method="GET" class="bg-linear-surface-1 p-3 md:p-4 rounded-3xl border border-linear-hairline flex flex-col md:flex-row gap-3 max-w-4xl mx-auto relative z-20">
                <div class="flex-1 flex items-center bg-linear-surface-2 rounded-2xl px-4 py-3 border border-transparent focus-within:border-linear-primary transition-all">
                    <i data-lucide="search" class="w-5 h-5 text-linear-ink-subtle"></i>
                    <input type="text" name="keyword" placeholder="Posisi pekerjaan, kata kunci..." class="w-full bg-transparent border-none focus:ring-0 text-linear-ink placeholder-linear-ink-subtle text-sm md:text-base px-3">
                </div>
                <div class="flex-1 flex items-center bg-linear-surface-2 rounded-2xl px-4 py-3 border border-transparent focus-within:border-linear-primary transition-all">
                    <i data-lucide="map-pin" class="w-5 h-5 text-linear-ink-subtle"></i>
                    <input type="text" name="location" placeholder="Lokasi (mis. Jakarta, Remote)" class="w-full bg-transparent border-none focus:ring-0 text-linear-ink placeholder-linear-ink-subtle text-sm md:text-base px-3">
                </div>
                <button type="submit" class="bg-linear-primary hover:bg-linear-primary-hover text-white font-semibold py-3 md:py-4 px-8 rounded-2xl transition-all flex items-center justify-center gap-2">
                    <span>Cari</span>
                </button>
            </form>

            <!-- Stats -->
            <div class="mt-16 flex flex-wrap justify-center gap-8 md:gap-16">
                <div class="text-center">
                    <p class="text-3xl font-extrabold text-linear-ink">10k+</p>
                    <p class="text-sm font-medium text-linear-ink-subtle mt-1">Lowongan Tersedia</p>
                </div>
                <div class="hidden sm:block w-px bg-linear-hairline"></div>
                <div class="text-center">
                    <p class="text-3xl font-extrabold text-linear-ink">2.5k+</p>
                    <p class="text-sm font-medium text-linear-ink-subtle mt-1">Perusahaan Mitra</p>
                </div>
                <div class="hidden sm:block w-px bg-linear-hairline"></div>
                <div class="text-center">
                    <p class="text-3xl font-extrabold text-linear-ink">50k+</p>
                    <p class="text-sm font-medium text-linear-ink-subtle mt-1">Pencari Kerja Aktif</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Jobs Section (Mockup) -->
<section class="py-20 bg-linear-canvas border-t border-linear-hairline">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-3xl font-bold text-linear-ink mb-2">Lowongan Populer</h2>
                <p class="text-linear-ink-muted">Peluang terbaru yang mungkin cocok untuk Anda.</p>
            </div>
            <a href="{{ route('jobs') }}" class="hidden sm:inline-flex items-center gap-2 text-linear-primary font-semibold hover:text-linear-primary-hover transition-colors">
                Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Job Card 1 -->
            <div class="bg-linear-surface-1 rounded-[1.5rem] p-6 border border-linear-hairline hover:border-linear-primary/50 transition-all duration-300 group hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-linear-surface-2 flex items-center justify-center border border-linear-hairline">
                        <i data-lucide="code" class="w-6 h-6 text-linear-primary"></i>
                    </div>
                    <span class="bg-linear-primary/10 text-linear-primary text-xs font-bold px-3 py-1 rounded-lg">Full Time</span>
                </div>
                <h3 class="text-xl font-bold text-linear-ink mb-1 group-hover:text-linear-primary transition-colors">Senior Frontend Developer</h3>
                <p class="text-linear-ink-subtle text-sm mb-4">Tech Innovators Inc.</p>
                <div class="flex items-center gap-4 text-sm text-linear-ink-subtle mb-6">
                    <div class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-4 h-4"></i> Jakarta Selatan</div>
                    <div class="flex items-center gap-1.5"><i data-lucide="banknote" class="w-4 h-4"></i> Rp 15-20 Jt</div>
                </div>
                <div class="border-t border-linear-hairline pt-5">
                    <a href="{{ route('jobs') }}" class="w-full inline-flex items-center justify-center py-2.5 px-4 bg-linear-surface-2 text-linear-ink font-semibold rounded-xl hover:bg-linear-primary hover:text-white transition-colors">Lihat Detail</a>
                </div>
            </div>
            
            <!-- Job Card 2 -->
            <div class="bg-linear-surface-1 rounded-[1.5rem] p-6 border border-linear-hairline hover:border-linear-primary/50 transition-all duration-300 group hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-linear-surface-2 flex items-center justify-center border border-linear-hairline">
                        <i data-lucide="pie-chart" class="w-6 h-6 text-linear-primary"></i>
                    </div>
                    <span class="bg-linear-primary/10 text-linear-primary text-xs font-bold px-3 py-1 rounded-lg">Remote</span>
                </div>
                <h3 class="text-xl font-bold text-linear-ink mb-1 group-hover:text-linear-primary transition-colors">Data Analyst</h3>
                <p class="text-linear-ink-subtle text-sm mb-4">Global Analytics Corp</p>
                <div class="flex items-center gap-4 text-sm text-linear-ink-subtle mb-6">
                    <div class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-4 h-4"></i> Remote (ID)</div>
                    <div class="flex items-center gap-1.5"><i data-lucide="banknote" class="w-4 h-4"></i> Rp 8-12 Jt</div>
                </div>
                <div class="border-t border-linear-hairline pt-5">
                    <a href="{{ route('jobs') }}" class="w-full inline-flex items-center justify-center py-2.5 px-4 bg-linear-surface-2 text-linear-ink font-semibold rounded-xl hover:bg-linear-primary hover:text-white transition-colors">Lihat Detail</a>
                </div>
            </div>

            <!-- Job Card 3 -->
            <div class="bg-linear-surface-1 rounded-[1.5rem] p-6 border border-linear-hairline hover:border-linear-primary/50 transition-all duration-300 group hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-linear-surface-2 flex items-center justify-center border border-linear-hairline">
                        <i data-lucide="pen-tool" class="w-6 h-6 text-linear-primary"></i>
                    </div>
                    <span class="bg-linear-primary/10 text-linear-primary text-xs font-bold px-3 py-1 rounded-lg">Full Time</span>
                </div>
                <h3 class="text-xl font-bold text-linear-ink mb-1 group-hover:text-linear-primary transition-colors">UI/UX Designer</h3>
                <p class="text-linear-ink-subtle text-sm mb-4">Creative Studio Jkt</p>
                <div class="flex items-center gap-4 text-sm text-linear-ink-subtle mb-6">
                    <div class="flex items-center gap-1.5"><i data-lucide="map-pin" class="w-4 h-4"></i> Jakarta Pusat</div>
                    <div class="flex items-center gap-1.5"><i data-lucide="banknote" class="w-4 h-4"></i> Rp 10-15 Jt</div>
                </div>
                <div class="border-t border-linear-hairline pt-5">
                    <a href="{{ route('jobs') }}" class="w-full inline-flex items-center justify-center py-2.5 px-4 bg-linear-surface-2 text-linear-ink font-semibold rounded-xl hover:bg-linear-primary hover:text-white transition-colors">Lihat Detail</a>
                </div>
            </div>
        </div>
        
        <div class="mt-8 text-center sm:hidden">
            <a href="{{ route('jobs') }}" class="inline-flex items-center gap-2 text-linear-primary font-semibold hover:text-linear-primary-hover transition-colors">
                Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
    </div>
</section>

<!-- Top Companies Section -->
<section class="py-20 bg-linear-canvas border-t border-linear-hairline">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-linear-ink mb-4">Perusahaan Pilihan Terbaik</h2>
            <p class="text-linear-ink-muted max-w-2xl mx-auto">Kami bekerjasama dengan perusahaan terkemuka yang siap mendukung perkembangan karier Anda menuju level berikutnya.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @for ($i = 1; $i <= 4; $i++)
            <div class="bg-linear-surface-1 rounded-[1.5rem] p-6 flex flex-col items-center justify-center text-center border border-linear-hairline hover:border-linear-primary/50 hover:bg-linear-surface-2 transition-all duration-300">
                <div class="w-16 h-16 rounded-2xl bg-linear-surface-3 shadow-sm flex items-center justify-center mb-4 border border-linear-hairline">
                    <i data-lucide="building-2" class="w-8 h-8 text-linear-ink-subtle"></i>
                </div>
                <h4 class="font-bold text-linear-ink mb-1">Company {{ $i }}</h4>
                <div class="flex items-center gap-1 text-amber-400 text-sm mb-3">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <span class="text-linear-ink-subtle font-medium">4.{{ 8 - $i }}</span>
                </div>
                <span class="text-xs font-semibold text-linear-primary bg-linear-primary/10 px-3 py-1 rounded-full">{{ 15 + ($i * 5) }} Lowongan</span>
            </div>
            @endfor
        </div>
    </div>
</section>
@endsection