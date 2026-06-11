@extends('layouts.main')

@section('title', 'Lowongan Tersimpan - Look For Job')

@section('content')
<div class="bg-linear-canvas min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-linear-ink mb-2">Lowongan <span class="text-linear-primary">Tersimpan</span></h1>
                <p class="text-linear-ink-muted">Kelola daftar pekerjaan yang menarik minat Anda.</p>
            </div>
            <a href="{{ route('jobs') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-linear-surface-1 border border-linear-hairline text-sm font-semibold rounded-xl text-linear-ink hover:bg-linear-surface-2 transition-colors shadow-none">
                Cari Lowongan Lain
            </a>
        </div>

        @if(session('status'))
            <div class="mb-6 p-4 rounded-xl bg-linear-primary/10 text-linear-primary border border-transparent flex items-start gap-3">
                <i data-lucide="check-circle-2" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                <div>
                    <h4 class="font-bold text-sm">Informasi</h4>
                    <p class="text-sm mt-1">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        @if ($savedJobs->isEmpty())
            <div class="bg-linear-surface-1 rounded-3xl border border-linear-hairline p-12 text-center shadow-none">
                <div class="w-20 h-20 bg-linear-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="bookmark" class="w-10 h-10 text-linear-primary"></i>
                </div>
                <h3 class="text-2xl font-bold text-linear-ink mb-2">Belum ada lowongan tersimpan</h3>
                <p class="text-linear-ink-subtle max-w-md mx-auto mb-6">Anda belum menyimpan pekerjaan apapun. Mulai telusuri dan simpan pekerjaan yang cocok untuk Anda!</p>
                <a href="{{ route('jobs') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-linear-primary text-white font-semibold hover:bg-linear-primary-hover transition-colors shadow-none">
                    <i data-lucide="search" class="w-4 h-4"></i> Telusuri Lowongan
                </a>
            </div>
        @else
            <div class="bg-linear-surface-1 rounded-3xl border border-linear-hairline shadow-none overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-linear-surface-2 border-b border-linear-hairline text-sm font-semibold text-linear-ink-subtle uppercase tracking-wider">
                                <th class="p-6">Posisi & Perusahaan</th>
                                <th class="p-6">Lokasi</th>
                                <th class="p-6">Tanggal Disimpan</th>
                                <th class="p-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-linear-hairline">
                            @foreach ($savedJobs as $job)
                                <tr class="hover:bg-linear-surface-2 transition-colors group">
                                    <td class="p-6">
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-linear-surface-2 border border-linear-hairline flex flex-shrink-0 items-center justify-center text-xl font-bold text-linear-ink-subtle">
                                                {{ substr($job->company, 0, 1) }}
                                            </div>
                                            <div>
                                                <a href="{{ route('jobs.detail', ['title' => $job->title, 'company' => $job->company, 'location' => $job->location, 'url' => $job->url]) }}" class="font-bold text-linear-ink mb-1 group-hover:text-linear-primary transition-colors block">{{ $job->title }}</a>
                                                <p class="text-sm text-linear-ink-muted flex items-center gap-1.5">
                                                    <i data-lucide="building-2" class="w-3.5 h-3.5"></i> {{ $job->company }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <span class="text-sm font-medium text-linear-ink">{{ $job->location ?: '-' }}</span>
                                    </td>
                                    <td class="p-6">
                                        <span class="text-sm font-medium text-linear-ink">{{ $job->created_at->format('d M Y') }}</span>
                                        <span class="block text-xs text-linear-ink-subtle mt-1">{{ $job->created_at->format('H:i') }} WIB</span>
                                    </td>
                                    <td class="p-6 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <form action="{{ route('saved-jobs.toggle') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="job_id" value="{{ $job->job_id }}">
                                                <input type="hidden" name="title" value="{{ $job->title }}">
                                                <input type="hidden" name="company" value="{{ $job->company }}">
                                                <button type="submit" class="p-2 text-linear-ink-subtle hover:text-red-500 hover:bg-red-500/10 rounded-lg transition-colors" title="Hapus dari tersimpan">
                                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('jobs.detail', ['title' => $job->title, 'company' => $job->company, 'location' => $job->location, 'url' => $job->url]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-linear-primary/10 text-linear-primary text-sm font-semibold rounded-xl hover:bg-linear-primary hover:text-white transition-colors">
                                                Lamar <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($savedJobs->hasPages())
                    <div class="p-6 border-t border-linear-hairline bg-linear-surface-2">
                        {{ $savedJobs->links() }}
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
