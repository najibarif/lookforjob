@extends('layouts.main')

@section('title', 'LookForJob - ' . __('Find Your Dream Job Faster'))

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-emerald-50 dark:from-emerald-950/40 via-white dark:via-slate-950 to-teal-50 dark:to-teal-950/40 min-h-[90vh] flex items-center overflow-hidden transition-colors duration-300">
    <!-- Subtle Background Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-emerald-400/20 dark:bg-emerald-500/10 rounded-full blur-3xl opacity-60 animate-pulse-glow pointer-events-none"></div>
    <div class="absolute -top-32 -right-32 w-[600px] h-[600px] bg-teal-400/10 dark:bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10 py-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            
            <div class="max-w-2xl animate-fade-up">
                <div class="mb-8">
                    <h2 class="inline-flex items-center gap-3 text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-400 dark:to-teal-300 font-black uppercase tracking-[0.25em] text-xs sm:text-sm drop-shadow-sm border-l-4 border-emerald-500 pl-4 py-1">
                        {{ __('The #1 Job Search Platform in Indonesia') }}
                    </h2>
                </div>

                <h1 class="text-5xl lg:text-[64px] font-extrabold text-slate-900 dark:text-white leading-[1.1] tracking-tight mb-6 transition-colors">
                    {{ __('Find Your') }} <span class="text-emerald-500">{{ __('Dream Job') }}</span> {{ __('Faster') }}
                </h1>
                
                <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 mb-10 leading-relaxed transition-colors">
                    {{ __('Discover thousands of verified opportunities from top companies. Your next career move starts here.') }}
                </p>

                <!-- Search Box -->
                <form action="{{ route('jobs') }}" method="GET" class="bg-white dark:bg-slate-900 p-2 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row gap-2 mb-12 relative z-20 transition-all">
                    <div class="flex-1 flex items-center bg-slate-50 dark:bg-slate-800 rounded-xl px-4 py-3 border border-transparent focus-within:border-emerald-300 dark:focus-within:border-emerald-500 focus-within:bg-white dark:focus-within:bg-slate-900 transition-all">
                        <i data-lucide="search" class="w-5 h-5 text-slate-400 dark:text-slate-500"></i>
                        <input type="text" name="keyword" placeholder="{{ __('Job title, keywords...') }}" class="w-full bg-transparent border-none focus:ring-0 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 px-3">
                    </div>
                    <div class="hidden sm:block w-px bg-slate-200 dark:bg-slate-700 my-2"></div>
                    <div class="flex-1 flex items-center bg-slate-50 dark:bg-slate-800 rounded-xl px-4 py-3 border border-transparent focus-within:border-emerald-300 dark:focus-within:border-emerald-500 focus-within:bg-white dark:focus-within:bg-slate-900 transition-all">
                        <i data-lucide="map-pin" class="w-5 h-5 text-slate-400 dark:text-slate-500"></i>
                        <input type="text" name="location" placeholder="{{ __('Location') }}" class="w-full bg-transparent border-none focus:ring-0 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 px-3">
                    </div>
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md shadow-emerald-500/20 whitespace-nowrap">
                        {{ __('Search Jobs') }}
                    </button>
                </form>

                <!-- Floating Stats -->
                <div class="flex flex-wrap items-center gap-6 sm:gap-10">
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold text-slate-900 dark:text-white transition-colors">15,000+</span>
                        <span class="text-sm text-slate-500 dark:text-slate-400 font-medium">{{ __('Active Jobs') }}</span>
                    </div>
                    <div class="w-px h-8 bg-slate-200 dark:bg-slate-800"></div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold text-slate-900 dark:text-white transition-colors">2,500+</span>
                        <span class="text-sm text-slate-500 dark:text-slate-400 font-medium">{{ __('Companies') }}</span>
                    </div>
                    <div class="w-px h-8 bg-slate-200 dark:bg-slate-800 hidden sm:block"></div>
                    <div class="flex flex-col hidden sm:flex">
                        <span class="text-2xl font-bold text-slate-900 dark:text-white transition-colors">10,000+</span>
                        <span class="text-sm text-slate-500 dark:text-slate-400 font-medium">{{ __('Job Seekers') }}</span>
                    </div>
                </div>
            </div>

            <!-- Right Visual / Mockup -->
            <div class="hidden lg:block relative z-10 animate-fade-left">
                <div class="relative w-full max-w-lg mx-auto">
                    <!-- Background Glows -->
                    <div class="absolute top-0 -left-4 w-72 h-72 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                    <div class="absolute top-0 -right-4 w-72 h-72 bg-teal-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
                    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-emerald-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

                    <!-- Main App Card Mockup -->
                    <div class="relative bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 dark:border-slate-800 p-6 z-10">
                        <!-- Top header -->
                        <div class="flex items-center justify-between mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                    <i data-lucide="search" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-white leading-none mb-1">{{ __('Search Jobs') }}</p>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400">{{ __('Enter keyword...') }}</p>
                                </div>
                            </div>
                            <div class="flex gap-1.5">
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-200 dark:bg-slate-700"></div>
                            </div>
                        </div>
                        
                        <!-- List Items -->
                        <div class="space-y-4">
                            <!-- Job 1 -->
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700/50 transition-all hover:scale-[1.02]">
                                <div class="w-12 h-12 rounded-xl bg-emerald-500 flex items-center justify-center text-white shrink-0 shadow-lg shadow-emerald-500/30">
                                    <i data-lucide="code" class="w-6 h-6"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <p class="text-sm font-bold text-slate-800 dark:text-white">{{ __('Software Engineer') }}</p>
                                        <span class="px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold rounded-full">NEW</span>
                                    </div>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">{{ __('Jakarta') }} &bull; {{ __('Full Time') }}</p>
                                </div>
                            </div>

                            <!-- Job 2 -->
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700/50 transition-all hover:scale-[1.02]">
                                <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center text-white shrink-0 shadow-lg shadow-blue-500/30">
                                    <i data-lucide="figma" class="w-6 h-6"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center mb-1">
                                        <p class="text-sm font-bold text-slate-800 dark:text-white">{{ __('UI/UX Designer') }}</p>
                                        <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 text-[10px] font-bold rounded-full">REMOTE</span>
                                    </div>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">{{ __('TechCorp') }} &bull; {{ __('Contract') }}</p>
                                </div>
                            </div>
                            
                            <!-- Apply Button -->
                            <div class="mt-6 pt-2">
                                <div class="h-12 w-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/30 cursor-pointer hover:shadow-xl hover:scale-[1.02] transition-all">
                                    <span class="text-sm font-bold text-white">{{ __('Apply Now') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
</section>



<!-- Featured Jobs Section -->
<section class="py-24 bg-slate-50 dark:bg-slate-950 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-4 tracking-tight">{{ __('Featured Opportunities') }}</h2>
                <p class="text-slate-600 dark:text-slate-400 text-lg">{{ __('Hand-picked jobs from top tech companies.') }}</p>
            </div>
            <a href="{{ route('jobs') }}" class="inline-flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-semibold hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                {{ __('View All Jobs') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredJobs as $job)
            <a href="{{ route('jobs.detail', ['title' => $job->title, 'company' => $job->company, 'location' => $job->location, 'url' => $job->url]) }}" class="group bg-white dark:bg-slate-900 rounded-[24px] p-6 border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-xl hover:shadow-emerald-500/5 hover:border-emerald-200 dark:hover:border-emerald-800 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="absolute top-0 left-0 w-full h-1 bg-emerald-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="briefcase" class="w-7 h-7 text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                        @if($loop->first)
                        <span class="bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">NEW</span>
                        @endif
                    </div>
                    @php
                        $rawTitle = $job->title;
                        $salary = null;
                        $parts = explode(' - ', $rawTitle);
                        if (count($parts) > 1) {
                            $lastPart = end($parts);
                            if (preg_match('/\d+/', $lastPart) && preg_match('/[\x{20AC}\$\x{00A3}]|EUR|USD|Rp/u', $lastPart)) {
                                $salary = trim($lastPart);
                            }
                        }
                        if (!$salary && preg_match('/(mindestens\s*)?[\d\.,]+(\s*k)?\s*(\x{20AC}|\$|\x{00A3}|EUR|USD|Rp)/iu', $rawTitle, $m)) {
                            $salary = $m[0];
                        }
                        
                        $cleanTitle = $rawTitle;
                        $cleanTitle = explode(' - ', $cleanTitle)[0];
                        $cleanTitle = explode(' – ', $cleanTitle)[0];
                        $cleanTitle = explode(',', $cleanTitle)[0];
                        $cleanTitle = explode(' (', $cleanTitle)[0];
                        $cleanTitle = trim($cleanTitle);
                    @endphp
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors line-clamp-2">{{ $cleanTitle }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-6 font-medium line-clamp-1">{{ $job->company }} • {{ $job->location }}</p>
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-3 py-1 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm rounded-lg font-medium">{{ __('Full Time') }}</span>
                        @if($job->is_remote)
                        <span class="px-3 py-1 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm rounded-lg font-medium">{{ __('Remote') }}</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center justify-between pt-6 border-t border-slate-100 dark:border-slate-800 mt-auto">
                    <div>
                        @if($salary)
                            <span class="text-lg font-bold text-slate-900 dark:text-white block">{{ $salary }}</span>
                        @endif
                        <span class="text-sm font-medium text-slate-500 dark:text-slate-400">
                            @if($job->date_posted)
                                {{ \Carbon\Carbon::parse(is_numeric($job->date_posted) ? (int)$job->date_posted : $job->date_posted)->diffForHumans() }}
                            @else
                                {{ __('Recently added') }}
                            @endif
                        </span>
                    </div>
                    <button class="w-10 h-10 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors">
                        <i data-lucide="heart" class="w-5 h-5"></i>
                    </button>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Career Tools -->
<section class="py-24 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-6 tracking-tight">{{ __('Career Tools Built for You') }}</h2>
            <p class="text-lg text-slate-600 dark:text-slate-400">{{ __('Everything you need to land your dream job faster and stand out from the crowd.') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Tool 1 -->
            <div class="group relative bg-slate-50 dark:bg-slate-800/50 rounded-[32px] p-8 border border-slate-100 dark:border-slate-700 overflow-hidden hover:border-emerald-200 dark:hover:border-emerald-700 transition-colors">
                <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i data-lucide="file-text" class="w-32 h-32 text-emerald-500 transform rotate-12"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-600 flex items-center justify-center mb-6">
                        <i data-lucide="sparkles" class="w-7 h-7 text-emerald-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">{{ __('AI Resume Builder') }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-sm">{{ __('Create a professional, ATS-friendly resume in minutes with our AI-powered tool.') }}</p>
                    <a href="#" class="inline-flex items-center gap-2 font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                        {{ __('Build Resume') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Tool 2 -->
            <div class="group relative bg-slate-50 dark:bg-slate-800/50 rounded-[32px] p-8 border border-slate-100 dark:border-slate-700 overflow-hidden hover:border-emerald-200 dark:hover:border-emerald-700 transition-colors">
                <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i data-lucide="layout-dashboard" class="w-32 h-32 text-emerald-500 transform -rotate-12"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-600 flex items-center justify-center mb-6">
                        <i data-lucide="kanban" class="w-7 h-7 text-emerald-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">{{ __('Application Tracking') }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-sm">{{ __('Keep track of all your job applications, interview stages, and offers in one place.') }}</p>
                    <a href="#" class="inline-flex items-center gap-2 font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                        {{ __('View Dashboard') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Tool 3 -->
            <div class="group relative bg-slate-50 dark:bg-slate-800/50 rounded-[32px] p-8 border border-slate-100 dark:border-slate-700 overflow-hidden hover:border-emerald-200 dark:hover:border-emerald-700 transition-colors">
                <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i data-lucide="message-square" class="w-32 h-32 text-emerald-500 transform rotate-6"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-600 flex items-center justify-center mb-6">
                        <i data-lucide="mic" class="w-7 h-7 text-emerald-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">{{ __('Interview Prep') }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-sm">{{ __('Practice with AI-generated questions tailored to the specific role you\'re applying for.') }}</p>
                    <a href="#" class="inline-flex items-center gap-2 font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                        {{ __('Start Practice') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>

            <!-- Tool 4 -->
            <div class="group relative bg-slate-50 dark:bg-slate-800/50 rounded-[32px] p-8 border border-slate-100 dark:border-slate-700 overflow-hidden hover:border-emerald-200 dark:hover:border-emerald-700 transition-colors">
                <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i data-lucide="trending-up" class="w-32 h-32 text-emerald-500 transform -rotate-6"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-600 flex items-center justify-center mb-6">
                        <i data-lucide="bar-chart-3" class="w-7 h-7 text-emerald-500"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">{{ __('Salary Insights') }}</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-sm">{{ __('Discover real-time compensation data to help you negotiate your worth confidently.') }}</p>
                    <a href="#" class="inline-flex items-center gap-2 font-semibold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                        {{ __('View Insights') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-24 bg-teal-50/30 dark:bg-teal-950/20 border-t border-slate-100 dark:border-slate-800 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-slate-900 dark:text-white mb-16 text-center tracking-tight">{{ __('Loved by Professionals') }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-slate-900 p-8 rounded-[24px] border border-slate-100 dark:border-slate-800 shadow-sm relative">
                <i data-lucide="quote" class="absolute top-6 right-6 w-8 h-8 text-emerald-100 dark:text-emerald-900/50"></i>
                <div class="flex gap-1 text-emerald-400 dark:text-emerald-500 mb-6">
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                </div>
                <p class="text-slate-600 dark:text-slate-400 text-lg mb-8">{{ __('I found my dream role at a top startup within 2 weeks of using LookForJob. The UI is incredibly clean and the AI tools are a game-changer.') }}</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden flex items-center justify-center font-bold text-slate-500 dark:text-slate-400">
                        S
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white">Sarah Jenkins</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Product Manager @ Stripe') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-8 rounded-[24px] border border-slate-100 dark:border-slate-800 shadow-sm relative">
                <i data-lucide="quote" class="absolute top-6 right-6 w-8 h-8 text-emerald-100 dark:text-emerald-900/50"></i>
                <div class="flex gap-1 text-emerald-400 dark:text-emerald-500 mb-6">
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                </div>
                <p class="text-slate-600 dark:text-slate-400 text-lg mb-8">{{ __('The quality of opportunities here is unmatched. No more scrolling through spam jobs. Everything feels curated and premium.') }}</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden flex items-center justify-center font-bold text-slate-500 dark:text-slate-400">
                        M
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white">Michael Chen</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Frontend Engineer @ Linear') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-8 rounded-[24px] border border-slate-100 dark:border-slate-800 shadow-sm relative">
                <i data-lucide="quote" class="absolute top-6 right-6 w-8 h-8 text-emerald-100 dark:text-emerald-900/50"></i>
                <div class="flex gap-1 text-emerald-400 dark:text-emerald-500 mb-6">
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                    <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                </div>
                <p class="text-slate-600 dark:text-slate-400 text-lg mb-8">{{ __('As a fresh grad, the AI Resume builder helped me translate my university projects into real-world value. Highly recommended.') }}</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden flex items-center justify-center font-bold text-slate-500 dark:text-slate-400">
                        A
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 dark:text-white">Amanda Putri</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('Data Analyst @ Goto') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics (Dark) -->
<section class="py-24 bg-slate-900 text-white relative overflow-hidden">
    <!-- Grid Pattern -->
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:40px_40px] opacity-20 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12">
            <div class="text-center">
                <p class="text-5xl font-extrabold text-emerald-400 mb-2 tracking-tight">10k+</p>
                <p class="text-slate-400 font-medium">{{ __('Successful Hires') }}</p>
            </div>
            <div class="text-center">
                <p class="text-5xl font-extrabold text-white mb-2 tracking-tight">2.5k</p>
                <p class="text-slate-400 font-medium">{{ __('Partner Companies') }}</p>
            </div>
            <div class="text-center">
                <p class="text-5xl font-extrabold text-white mb-2 tracking-tight">15k+</p>
                <p class="text-slate-400 font-medium">{{ __('Active Jobs') }}</p>
            </div>
            <div class="text-center">
                <p class="text-5xl font-extrabold text-white mb-2 tracking-tight">98%</p>
                <p class="text-slate-400 font-medium">{{ __('User Satisfaction') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA -->
<section class="py-24 bg-gradient-to-br from-emerald-500 to-emerald-700 text-center px-4">
    <div class="max-w-3xl mx-auto">
        <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6 tracking-tight">{{ __('Ready for Your Next Career Move?') }}</h2>
        <p class="text-emerald-50 text-xl mb-10 max-w-2xl mx-auto">{{ __('Join thousands of professionals finding their dream jobs on our premium platform.') }}</p>
        <a href="{{ route('jobs') }}" class="inline-block bg-white text-emerald-600 font-bold text-lg py-4 px-10 rounded-full shadow-xl shadow-emerald-900/20 hover:scale-105 hover:shadow-2xl transition-all duration-300">
            {{ __('Start Searching Jobs') }}
        </a>
    </div>
</section>

@endsection