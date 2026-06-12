<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LookForJob - Modern Job Search Platform')</title>
    <meta name="description" content="@yield('meta_description', 'Find your dream job faster. Discover thousands of verified opportunities from top companies.')">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50 dark:bg-slate-950 dark:text-slate-100 flex flex-col min-h-screen selection:bg-emerald-700/30">
    
    <!-- Navbar -->
    <header class="sticky top-0 z-50 w-full bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-all duration-300" x-data="{ mobileMenuOpen: false }">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-700 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                    <i data-lucide="briefcase" class="text-white w-5 h-5"></i>
                </div>
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    LookFor<span class="text-emerald-500">Job</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-emerald-500' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }} transition-colors">{{ __('Home') }}</a>
                <a href="{{ route('jobs') }}" class="text-sm font-medium {{ request()->routeIs('jobs') ? 'text-emerald-500' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }} transition-colors">{{ __('Jobs') }}</a>

                @auth
                <a href="{{ route('saved-jobs.index') }}" class="text-sm font-medium {{ request()->routeIs('saved-jobs.index') ? 'text-emerald-500' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }} transition-colors">{{ __('Saved') }}</a>
                <a href="{{ route('applications.index') }}" class="text-sm font-medium {{ request()->routeIs('applications.index') ? 'text-emerald-500' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }} transition-colors">{{ __('Applications') }}</a>
                @endauth

                <!-- Career Tools Dropdown -->
                <div class="relative" x-data="{ careerToolsOpen: false }" @click.away="careerToolsOpen = false">
                    <button @click="careerToolsOpen = !careerToolsOpen" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors flex items-center gap-1.5 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 px-3 py-2 rounded-lg">
                        {{ __('Career Tools') }}
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="careerToolsOpen ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="careerToolsOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-72 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 py-2 z-50 overflow-hidden">
                        @auth
                        <a href="{{ route('cv') }}" class="group block px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center group-hover:bg-emerald-200 dark:group-hover:bg-emerald-800 transition-colors">
                                    <i data-lucide="file-text" class="w-4 h-4 text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ __('AI Resume Builder') }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('Create professional resume') }}</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('career-tools.interview-prep') }}" class="group block px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center group-hover:bg-blue-200 dark:group-hover:bg-blue-800 transition-colors">
                                    <i data-lucide="help-circle" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ __('Interview Prep') }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('Practice interview questions') }}</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('career-tools.salary-insights') }}" class="group block px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-violet-100 dark:bg-violet-900/50 flex items-center justify-center group-hover:bg-violet-200 dark:group-hover:bg-violet-800 transition-colors">
                                    <i data-lucide="trending-up" class="w-4 h-4 text-violet-600 dark:text-violet-400"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ __('Salary Insights') }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('View salary data') }}</p>
                                </div>
                            </div>
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="group block px-4 py-3 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center group-hover:bg-slate-200 dark:group-hover:bg-slate-700 transition-colors">
                                    <i data-lucide="log-in" class="w-4 h-4 text-slate-600 dark:text-slate-400"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ __('Login Required') }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('Sign in to access career tools') }}</p>
                                </div>
                            </div>
                        </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Desktop Auth -->
            <div class="hidden md:flex items-center gap-4">
                
                <!-- Theme & Lang Toggle -->
                <div class="hidden md:flex items-center gap-2 border-r border-slate-200 dark:border-slate-700 pr-4 mr-1" x-data="{ darkMode: document.documentElement.classList.contains('dark') }">
                    <!-- Theme Toggle -->
                    <button @click="darkMode = !darkMode; if(darkMode) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; }" 
                            class="p-2 text-slate-500 dark:text-slate-400 hover:text-emerald-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors"
                            aria-label="{{ __('Toggle dark mode') }}">
                        <i x-show="!darkMode" data-lucide="moon" class="w-5 h-5"></i>
                        <i x-show="darkMode" data-lucide="sun" class="w-5 h-5 hidden" :class="{'hidden': !darkMode}"></i>
                    </button>
                    
                    <!-- Lang Toggle -->
                    <div class="relative" x-data="{ openLang: false }">
                        <button @click="openLang = !openLang" @click.away="openLang = false" class="flex items-center gap-1 p-2 text-slate-500 dark:text-slate-400 hover:text-emerald-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors font-medium text-sm" aria-label="{{ __('Toggle language') }}">
                            {{ strtoupper(app()->getLocale()) }}
                            <i data-lucide="chevron-down" class="w-3 h-3"></i>
                        </button>
                        <div x-show="openLang" class="absolute right-0 mt-2 w-32 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 py-2 hidden" :class="{'hidden': !openLang}">
                            <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm {{ app()->getLocale() == 'en' ? 'text-emerald-500 font-bold' : 'text-slate-600 dark:text-slate-300' }} hover:bg-slate-50 dark:hover:bg-slate-700">English</a>
                            <a href="{{ route('lang.switch', 'id') }}" class="block px-4 py-2 text-sm {{ app()->getLocale() == 'id' ? 'text-emerald-500 font-bold' : 'text-slate-600 dark:text-slate-300' }} hover:bg-slate-50 dark:hover:bg-slate-700">Indonesia</a>
                        </div>
                    </div>
                </div>

                  @auth
                      <div class="relative" x-data="{ open: false }">
                          <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 hover:bg-slate-100 dark:hover:bg-slate-800 p-2 rounded-full transition-colors">
                              <div class="w-9 h-9 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400 flex items-center justify-center font-bold text-sm">
                                  {{ substr(Auth::user()->name, 0, 1) }}
                              </div>
                              <span class="text-sm font-medium text-slate-900 dark:text-white">{{ Auth::user()->name }}</span>
                              <i data-lucide="chevron-down" class="w-4 h-4 text-slate-500 dark:text-slate-400"></i>
                          </button>
                          <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 py-2 hidden" :class="{'hidden': !open}">
                              <form method="POST" action="{{ route('logout') }}">
                                  @csrf
                                  <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 font-medium transition-colors rounded-xl">
                                      {{ __('Logout') }}
                                  </button>
                              </form>
                          </div>
                      </div>
                  @else
                      <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-900 dark:text-white hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">{{ __('Login') }}</a>
                      <a href="{{ Route::has('register') ? route('register') : '#' }}" class="text-sm font-semibold text-white bg-emerald-700 hover:bg-emerald-700 px-5 py-2.5 rounded-full transition-all hover:-translate-y-0.5 shadow-md shadow-emerald-500/20">{{ __('Sign Up') }}</a>
                  @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-500 hover:text-emerald-500 transition-colors p-2" aria-label="{{ __('Toggle navigation menu') }}">
                    <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen"></i>
                    <i data-lucide="x" class="w-6 h-6 hidden" x-show="mobileMenuOpen" :class="{'hidden': !mobileMenuOpen}"></i>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="md:hidden bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 hidden shadow-xl" x-show="mobileMenuOpen" :class="{'hidden': !mobileMenuOpen}">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('home') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">{{ __('Home') }}</a>
                <a href="{{ route('jobs') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('jobs') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">{{ __('Jobs') }}</a>

                <!-- Career Tools Mobile Menu -->
                <div x-data="{ openCareerTools: false }" class="space-y-2">
                    <button @click="openCareerTools = !openCareerTools" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-base font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white">
                        <span class="flex items-center gap-2">
                            <i data-lucide="briefcase" class="w-4 h-4"></i>
                            {{ __('Career Tools') }}
                        </span>
                        <i data-lucide="chevron-down" class="w-4 h-4" :class="{'rotate-180': openCareerTools}"></i>
                    </button>
                    <div x-show="openCareerTools" class="pl-4 space-y-2">
                        @auth
                        <a href="{{ route('cv') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Resume Builder') }}</a>
                        <a href="{{ route('career-tools.interview-prep') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Interview Prep') }}</a>
                        <a href="{{ route('career-tools.salary-insights') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Salary Insights') }}</a>
                        @else
                        <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Login Required') }}</a>
                        @endauth
                    </div>
                </div>
                
                <div class="border-t border-slate-200 dark:border-slate-800 mt-4 pt-4">
                    @auth
                        <a href="{{ route('saved-jobs.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('saved-jobs.index') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">{{ __('Saved') }}</a>
                        <a href="{{ route('applications.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('applications.index') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">{{ __('Applications') }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-base font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">{{ __('Logout') }}</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800 mb-2">{{ __('Login') }}</a>
                        <a href="{{ Route::has('register') ? route('register') : '#' }}" class="block px-4 py-3 rounded-xl text-base font-medium text-center text-white bg-emerald-700 hover:bg-emerald-700 shadow-sm">{{ __('Sign Up') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Global Flash Messages -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms x-init="setTimeout(() => show = false, 5000)" class="fixed top-24 right-4 z-50 bg-emerald-700 text-white px-6 py-3 rounded-xl shadow-xl flex items-center gap-3">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span class="font-medium">{{ session('success') }}</span>
                <button @click="show = false" class="ml-4 text-emerald-100 hover:text-white" aria-label="Close notification"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms x-init="setTimeout(() => show = false, 7000)" class="fixed top-24 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-xl shadow-xl flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span class="font-medium">{{ session('error') }}</span>
                <button @click="show = false" class="ml-4 text-red-100 hover:text-white" aria-label="Close error message"><i data-lucide="x" class="w-4 h-4"></i></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-950 pt-20 pb-10 border-t border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Branding -->
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-emerald-700 flex items-center justify-center">
                            <i data-lucide="briefcase" class="text-white w-4 h-4"></i>
                        </div>
                        <span class="text-xl font-bold text-slate-900 dark:text-white transition-colors">LookFor<span class="text-emerald-500">Job</span></span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6">
                        Empowering professionals to discover their dream careers and modern companies to hire top-tier talent.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" aria-label="Twitter" class="text-slate-500 dark:text-slate-400 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                        <a href="#" aria-label="LinkedIn" class="text-slate-500 dark:text-slate-400 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                        <a href="#" aria-label="GitHub" class="text-slate-500 dark:text-slate-400 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg></a>
                    </div>
                </div>

                <!-- Product -->
                <div>
                    <h3 class="text-slate-900 dark:text-white font-semibold mb-6">Product</h3>
                    <ul class="space-y-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a href="{{ route('jobs') }}" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Search Jobs</a></li>
                        <li><a href="{{ route('companies') }}" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">{{ __('Browse Companies') }}</a></li>
                        <li><a href="#" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Salary Insights</a></li>
                        <li><a href="{{ route('cv') }}" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">AI Resume Builder</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h3 class="text-slate-900 dark:text-white font-semibold mb-6">Resources</h3>
                    <ul class="space-y-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a href="#" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Career Blog</a></li>
                        <li><a href="#" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Interview Prep</a></li>
                        <li><a href="#" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">API Documentation</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h3 class="text-slate-900 dark:text-white font-semibold mb-6">Company</h3>
                    <ul class="space-y-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a href="#" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-100 dark:border-slate-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-slate-500 dark:text-slate-400 text-sm">&copy; {{ date('Y') }} LookForJob Inc. All rights reserved.</p>
                <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                    <span>Designed by <a href="https://instagram.com/nnajibba" target="_blank" rel="noopener noreferrer" class="text-emerald-700 dark:text-emerald-400 hover:underline">@nnajibba</a></span>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const initIcons = () => {
                if (typeof window.lucide !== 'undefined') {
                    window.lucide.createIcons({ icons: window.lucide.icons });
                } else {
                    setTimeout(initIcons, 50);
                }
            };
            initIcons();
        });
    </script>
</body>
</html>
