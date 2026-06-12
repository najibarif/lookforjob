<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LookForJob - Modern Job Search Platform')</title>
    <meta name="description" content="@yield('meta_description', 'Find your dream job faster. Discover thousands of verified opportunities from top companies.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

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

                <a href="{{ route('cv') }}" class="text-sm font-medium {{ request()->routeIs('cv') ? 'text-emerald-500' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }} transition-colors">{{ __('Career Tools') }}</a>
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

                <a href="{{ route('cv') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('cv') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">{{ __('Career Tools') }}</a>
                
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
                        <a href="#" aria-label="Twitter" class="text-slate-500 dark:text-slate-400 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                        <a href="#" aria-label="LinkedIn" class="text-slate-500 dark:text-slate-400 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors"><i data-lucide="linkedin" class="w-5 h-5"></i></a>
                        <a href="#" aria-label="GitHub" class="text-slate-500 dark:text-slate-400 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors"><i data-lucide="github" class="w-5 h-5"></i></a>
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

    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const initIcons = () => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                } else {
                    setTimeout(initIcons, 50);
                }
            };
            initIcons();
        });
    </script>
    @livewireScripts
</body>
</html>
