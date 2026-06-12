@extends('layouts.main')

@section('title', __('Job Detail') . ' - ' . $title)

@section('content')
@php
    $cleanTitle = trim(preg_replace('/\s*\([mwfdx\s\/]+\)/i', '', $title));
    $jobId = md5($cleanTitle . $company);
    $isSaved = auth()->check() ? \App\Models\SavedJob::where('user_id', auth()->id())->where('job_id', $jobId)->exists() : false;
@endphp
<div class="bg-slate-50 dark:bg-slate-950 min-h-screen py-10 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex text-sm text-slate-400 dark:text-slate-500 mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">{{ __('Home') }}</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 mx-1"></i>
                        <a href="{{ route('jobs') }}" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">{{ __('Jobs') }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i data-lucide="chevron-right" class="w-4 h-4 mx-1"></i>
                        <span class="text-slate-900 dark:text-white font-medium line-clamp-1">{{ $cleanTitle }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 relative overflow-hidden transition-colors">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 dark:bg-emerald-500/5 rounded-full blur-2xl opacity-60"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row md:items-start justify-between gap-6">
                        <div class="flex gap-6">
                            <div class="w-20 h-20 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="building" class="w-10 h-10 text-emerald-500 dark:text-emerald-400"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $cleanTitle }}</h1>
                                    <span class="bg-emerald-500/10 dark:bg-emerald-900/30 text-emerald-500 dark:text-emerald-400 text-xs font-bold px-3 py-1 rounded-full border border-transparent">{{ __('New') }}</span>
                                </div>
                                <p class="text-lg text-slate-500 dark:text-slate-400 font-medium mb-4">{{ $company }}</p>
                                
                                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-400 dark:text-slate-500">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-slate-400 dark:text-slate-500"></i>
                                        {{ $location }}
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="briefcase" class="w-4 h-4 text-slate-400 dark:text-slate-500"></i>
                                        {{ __('Full Time') }}
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="banknote" class="w-4 h-4 text-slate-400 dark:text-slate-500"></i>
                                        {{ __('Confidential') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200 dark:border-slate-800 transition-colors">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-500 dark:text-emerald-400">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                        </div>
                        {{ __('Job Description') }}
                    </h2>
                    
                    <div class="prose prose-slate dark:prose-invert max-w-none prose-p:text-slate-500 dark:prose-p:text-slate-400 prose-p:leading-relaxed prose-li:text-slate-500 dark:prose-li:text-slate-400 prose-strong:text-slate-900 dark:prose-strong:text-white">
                        <p>{!! str_replace('{{ $cleanTitle }}', '<strong>' . $cleanTitle . '</strong>', __('We are looking for a passionate {{ $cleanTitle }} to join our team. You will be responsible for building amazing services and ensuring the best experience for our customers.')) !!}</p>
                        
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-6 mb-3">{{ __('Responsibilities:') }}</h3>
                        <ul class="space-y-2 list-disc pl-5">
                            <li>{{ __('Develop and maintain new features for our product.') }}</li>
                            <li>{{ __('Collaborate with the team to translate designs into efficient code or outputs.') }}</li>
                            <li>{{ __('Optimize systems for maximum speed and scalability.') }}</li>
                            <li>{{ __('Ensure the quality of work consistently.') }}</li>
                        </ul>
                        
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-6 mb-3">{{ __('Requirements:') }}</h3>
                        <ul class="space-y-2 list-disc pl-5">
                            <li>{{ __('Experience working as a professional in this field.') }}</li>
                            <li>{{ __('Deep understanding of relevant technologies and skills.') }}</li>
                            <li>{{ __('Able to work in a team and communicate well.') }}</li>
                        </ul>
                    </div>
                    
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-8 mb-4">{{ __('Required Skills') }}</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-400 dark:text-slate-500 hover:border-emerald-500 dark:hover:border-emerald-500 hover:bg-emerald-500/10 dark:hover:bg-emerald-900/30 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors cursor-pointer">{{ __('Communication') }}</span>
                        <span class="px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-400 dark:text-slate-500 hover:border-emerald-500 dark:hover:border-emerald-500 hover:bg-emerald-500/10 dark:hover:bg-emerald-900/30 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors cursor-pointer">{{ __('Teamwork') }}</span>
                        <span class="px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-400 dark:text-slate-500 hover:border-emerald-500 dark:hover:border-emerald-500 hover:bg-emerald-500/10 dark:hover:bg-emerald-900/30 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors cursor-pointer">{{ __('Innovative') }}</span>
                        <span class="px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-400 dark:text-slate-500 hover:border-emerald-500 dark:hover:border-emerald-500 hover:bg-emerald-500/10 dark:hover:bg-emerald-900/30 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors cursor-pointer">{{ __('Problem Solving') }}</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6 lg:sticky lg:top-28">
                <!-- Apply Card -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-emerald-500/30 dark:border-emerald-500/20 transition-colors">

                    <h3 class="font-bold text-slate-900 dark:text-white text-lg mb-2">{{ __('Interested in this position?') }}</h3>
                    <p class="text-sm text-slate-400 dark:text-slate-500 mb-6">{{ __('Apply now before the vacancy closes.') }}</p>
                    
                    <form action="{{ route('jobs.apply') }}" method="POST">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $jobId }}">
                        <input type="hidden" name="job_title" value="{{ $cleanTitle }}">
                        <input type="hidden" name="company_name" value="{{ $company }}">
                        <input type="hidden" name="job_url" value="{{ $url ?? '#' }}">
                        
                        <button type="submit" @if($url) onclick="window.open('{{ $url }}', '_blank')" @endif class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3.5 px-4 rounded-xl transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 mb-3">
                            {{ __('Apply Job') }} <i data-lucide="send" class="w-4 h-4"></i>
                        </button>
                    </form>
                    
                    <form action="{{ route('saved-jobs.toggle') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="job_id" value="{{ $jobId }}">
                        <input type="hidden" name="title" value="{{ $cleanTitle }}">
                        <input type="hidden" name="company" value="{{ $company }}">
                        <input type="hidden" name="location" value="{{ $location }}">
                        <input type="hidden" name="url" value="{{ $url ?? '#' }}">
                        
                        <button type="submit" class="w-full bg-slate-50 dark:bg-slate-800 border-2 {{ $isSaved ? 'border-emerald-500 bg-emerald-500/10 text-emerald-500 dark:text-emerald-400' : 'border-slate-200 dark:border-slate-700 hover:border-emerald-500 dark:hover:border-emerald-500 hover:bg-emerald-500/10 text-slate-900 dark:text-white' }} font-semibold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2">
                            {{ $isSaved ? __('Saved') : __('Save Job') }} <i data-lucide="bookmark" class="w-4 h-4 {{ $isSaved ? 'fill-current' : '' }}"></i>
                        </button>
                    </form>
                    
                    <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-800">
                        <div class="flex items-center gap-3 text-sm text-slate-400 dark:text-slate-500 mb-3">
                            <i data-lucide="share-2" class="w-4 h-4"></i>
                            <span class="font-medium text-slate-900 dark:text-white">{{ __('Share this job') }}</span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="copyLink()" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-500/10 dark:hover:bg-emerald-900/30 hover:text-emerald-500 dark:hover:text-emerald-400 text-slate-500 dark:text-slate-400 flex items-center justify-center transition-colors" title="{{ __('Copy Link') }}"><i data-lucide="link" class="w-4 h-4"></i></button>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-blue-500/10 dark:hover:bg-blue-900/30 hover:text-blue-500 dark:hover:text-blue-400 text-slate-500 dark:text-slate-400 flex items-center justify-center transition-colors"><i data-lucide="facebook" class="w-4 h-4"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text=Lowongan {{ urlencode($cleanTitle) }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-sky-500/10 dark:hover:bg-sky-900/30 hover:text-sky-500 dark:hover:text-sky-400 text-slate-500 dark:text-slate-400 flex items-center justify-center transition-colors"><i data-lucide="twitter" class="w-4 h-4"></i></a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($cleanTitle) }}" target="_blank" class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-blue-600/10 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 text-slate-500 dark:text-slate-400 flex items-center justify-center transition-colors"><i data-lucide="linkedin" class="w-4 h-4"></i></a>
                        </div>
                        <script>
                            function copyLink() {
                                navigator.clipboard.writeText(window.location.href).then(() => {
                                    alert("{{ __('Link copied to clipboard!') }}");
                                });
                            }
                        </script>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 transition-colors">
                    <h3 class="font-bold text-slate-900 dark:text-white text-lg mb-4">{{ __('About the Company') }}</h3>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="building-2" class="w-6 h-6 text-emerald-500 dark:text-emerald-400"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 dark:text-white">{{ $company }}</h4>
                            @if(isset($url) && $url)
                            <a href="{{ $url }}" target="_blank" class="text-sm text-emerald-500 hover:text-emerald-600 dark:hover:text-emerald-400 hover:underline">{{ __('View full profile') }}</a>
                            @endif
                        </div>
                    </div>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                        {{ __('Learn more about :company by visiting their official pages or viewing the full job post.', ['company' => $company]) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection