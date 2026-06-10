<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Look For Job - Temukan Karir Impian & Buat CV Profesional')</title>
    <meta name="description" content="@yield('meta_description', 'Cari lowongan pekerjaan impian Anda dan buat CV profesional berbasis AI dengan mudah di Look For Job.')">
    <meta name="keywords" content="@yield('meta_keywords', 'lowongan kerja, cari kerja, cv maker, cv builder, generator cv AI, template resume, lamar pekerjaan')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Look For Job - Temukan Karir Impian & Buat CV Profesional')">
    <meta property="og:description" content="@yield('meta_description', 'Cari lowongan pekerjaan impian Anda dan buat CV profesional berbasis AI dengan mudah di Look For Job.')">
    <meta property="og:image" content="{{ asset('favicon.ico') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Look For Job - Temukan Karir Impian & Buat CV Profesional')">
    <meta property="twitter:description" content="@yield('meta_description', 'Cari lowongan pekerjaan impian Anda dan buat CV profesional berbasis AI dengan mudah di Look For Job.')">
    <meta property="twitter:image" content="{{ asset('favicon.ico') }}">

    <!-- Preconnect Fonts for Performance -->
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Vite Assets (Local Compilation) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased text-gray-900 bg-slate-50 h-full flex flex-col">
    <!-- Skip to Content Link for Accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-indigo-600 text-white px-4 py-2 rounded-md shadow-lg z-50 transition duration-150">
        Skip to main content
    </a>

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 w-full backdrop-blur-md bg-white/80 border-b border-slate-200/60" x-data="{ mobileMenuOpen: false }">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Main Navigation">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md py-1" aria-label="Look For Job Home">
                        Look For Job
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex md:space-x-8 md:items-center">
                    <a href="{{ route('jobs') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 {{ request()->routeIs('jobs') ? 'border-indigo-600 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-sm">
                        Cari Lowongan
                    </a>
                    <a href="{{ route('cv') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 {{ request()->routeIs('cv') ? 'border-indigo-600 text-slate-900' : 'border-transparent text-slate-500 hover:border-slate-300 hover:text-slate-700' }} focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-sm">
                        Generate CV
                    </a>

                    <!-- Auth Dropdown / Actions -->
                    @auth
                        <div class="relative ml-3" x-data="{ dropdownOpen: false }">
                            <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" type="button" class="inline-flex items-center gap-2 px-3 py-2 border border-slate-200 rounded-full text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-slate-400 transition" :class="{'rotate-180': dropdownOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-1 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" style="display: none;">
                                <form method="POST" action="{{ route('logout') }}" role="none">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900 focus:bg-slate-100 focus:outline-none" role="menuitem">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            Login
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset-2 focus:ring-indigo-500" aria-controls="mobile-menu" :aria-expanded="mobileMenuOpen.toString()">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 h-6" :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 h-6" :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="md:hidden" id="mobile-menu" x-show="mobileMenuOpen" style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-b border-slate-200">
                <a href="{{ route('jobs') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('jobs') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                    Cari Lowongan
                </a>
                <a href="{{ route('cv') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('cv') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                    Generate CV
                </a>
                <div class="border-t border-slate-200 my-2 pt-2">
                    @auth
                        <div class="px-3 py-2 text-sm text-slate-600 font-medium truncate">
                            Login sebagai: {{ Auth::user()->name }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50 hover:text-red-700">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-indigo-600 hover:bg-slate-50">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main id="main-content" class="flex-grow focus:outline-none" tabindex="-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h2 class="text-white font-bold text-lg mb-4">Look For Job</h2>
                    <p class="text-sm">Asisten digital Anda untuk menemukan lowongan kerja impian dan menyusun resume terbaik yang didukung teknologi cerdas.</p>
                </div>
                <div>
                    <h2 class="text-white font-bold text-lg mb-4">Tautan Cepat</h2>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('jobs') }}" class="hover:text-white transition">Cari Lowongan Kerja</a></li>
                        <li><a href="{{ route('cv') }}" class="hover:text-white transition">Generator CV AI</a></li>
                    </ul>
                </div>
                <div>
                    <h2 class="text-white font-bold text-lg mb-4">Kontak & Bantuan</h2>
                    <p class="text-sm mb-2">Punya pertanyaan atau masukan? Hubungi kami.</p>
                    <p class="text-sm text-white font-medium">support@lookforjob.id</p>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-8 pt-8 text-center text-xs">
                <p>&copy; {{ date('Y') }} Look For Job. Hak Cipta Dilindungi Undang-Undang.</p>
            </div>
        </div>
    </footer>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
