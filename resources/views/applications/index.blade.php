@extends('layouts.main')

@section('title', 'Lamaran Saya - Look For Job')

@section('content')
<div class="bg-linear-canvas min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-linear-ink mb-2">Lamaran <span class="text-linear-primary">Saya</span></h1>
                <p class="text-linear-ink-muted">Lacak status dan riwayat lamaran pekerjaan Anda.</p>
            </div>
            <a href="{{ route('jobs') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-linear-surface-1 border border-linear-hairline text-sm font-semibold rounded-xl text-linear-ink hover:bg-linear-surface-2 transition-colors shadow-none">
                Cari Lowongan Lain
            </a>
        </div>

        @if ($applications->isEmpty())
            <div class="bg-linear-surface-1 rounded-3xl border border-linear-hairline p-12 text-center">
                <div class="w-20 h-20 bg-linear-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="inbox" class="w-10 h-10 text-linear-primary"></i>
                </div>
                <h3 class="text-2xl font-bold text-linear-ink mb-2">Belum ada lamaran</h3>
                <p class="text-linear-ink-subtle max-w-md mx-auto mb-6">Anda belum pernah melamar pekerjaan apapun di platform ini. Mulai cari karier impian Anda sekarang!</p>
                <a href="{{ route('jobs') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-linear-primary text-white font-semibold hover:bg-linear-primary-hover transition-colors shadow-none">
                    <i data-lucide="search" class="w-4 h-4"></i> Telusuri Lowongan
                </a>
            </div>
        @else
            <div class="bg-linear-surface-1 rounded-3xl border border-linear-hairline overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-linear-surface-2 border-b border-linear-hairline text-sm font-semibold text-linear-ink-subtle uppercase tracking-wider">
                                <th class="p-6">Posisi & Perusahaan</th>
                                <th class="p-6">Tanggal Melamar</th>
                                <th class="p-6">Status</th>
                                <th class="p-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-linear-hairline">
                            @foreach ($applications as $app)
                                <tr class="hover:bg-linear-surface-2 transition-colors group">
                                    <td class="p-6">
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-linear-surface-2 border border-linear-hairline flex flex-shrink-0 items-center justify-center text-xl font-bold text-linear-ink-subtle">
                                                {{ substr($app->company_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-linear-ink mb-1 group-hover:text-linear-primary transition-colors">{{ $app->job_title }}</h4>
                                                <p class="text-sm text-linear-ink-muted flex items-center gap-1.5">
                                                    <i data-lucide="building-2" class="w-3.5 h-3.5"></i> {{ $app->company_name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <span class="text-sm font-medium text-linear-ink">{{ $app->created_at->format('d M Y') }}</span>
                                        <span class="block text-xs text-linear-ink-subtle mt-1">{{ $app->created_at->format('H:i') }} WIB</span>
                                    </td>
                                    <td class="p-6">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-linear-primary/10 text-linear-primary text-xs font-semibold border border-transparent">
                                            <span class="w-1.5 h-1.5 rounded-full bg-linear-primary"></span> {{ $app->status }}
                                        </span>
                                    </td>
                                    <td class="p-6 text-right">
                                        <a href="{{ $app->job_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-semibold text-linear-primary hover:text-linear-primary-hover transition-colors">
                                            Lihat Lowongan <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($applications->hasPages())
                    <div class="p-6 border-t border-linear-hairline bg-linear-surface-2">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
