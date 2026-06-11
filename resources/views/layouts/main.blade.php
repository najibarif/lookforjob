<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Look For Job - Temukan Karier Impian Anda')</title>
    <meta name="description" content="@yield('meta_description', 'Platform pencarian kerja modern untuk menemukan lowongan dan membangun karier impian Anda.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased text-linear-ink bg-linear-canvas flex flex-col min-h-screen">
    
    <!-- Navbar -->
    <header class="sticky top-0 z-50 w-full bg-linear-canvas/80 backdrop-blur-xl border-b border-linear-hairline transition-all duration-300" x-data="{ mobileMenuOpen: false }">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-linear-primary flex items-center justify-center shadow-lg shadow-linear-primary/20">
                    <i data-lucide="briefcase" class="text-white w-5 h-5"></i>
                </div>
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight text-linear-ink">
                    LookFor<span class="text-linear-primary">Job</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-linear-primary' : 'text-linear-ink-subtle hover:text-linear-ink' }} transition-colors">Beranda</a>
                <a href="{{ route('jobs') }}" class="text-sm font-medium {{ request()->routeIs('jobs') ? 'text-linear-primary' : 'text-linear-ink-subtle hover:text-linear-ink' }} transition-colors">Lowongan</a>
                <a href="{{ route('cv') }}" class="text-sm font-medium {{ request()->routeIs('cv') ? 'text-linear-primary' : 'text-linear-ink-subtle hover:text-linear-ink' }} transition-colors">Buat CV</a>
            </div>

            <!-- Desktop Auth -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <a href="{{ route('saved-jobs.index') }}" class="text-sm font-semibold {{ request()->routeIs('saved-jobs.index') ? 'text-linear-primary' : 'text-linear-ink-subtle hover:text-linear-primary' }} transition-colors mr-2">Tersimpan</a>
                    <a href="{{ route('applications.index') }}" class="text-sm font-semibold {{ request()->routeIs('applications.index') ? 'text-linear-primary' : 'text-linear-ink-subtle hover:text-linear-primary' }} transition-colors mr-2">Lamaran Saya</a>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 hover:bg-linear-surface-1 p-2 rounded-full transition-colors">
                            <div class="w-9 h-9 rounded-full bg-linear-primary/20 text-linear-primary flex items-center justify-center font-bold text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium text-linear-ink">{{ Auth::user()->name }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-linear-ink-subtle"></i>
                        </button>
                        <div x-show="open" class="absolute right-0 mt-2 w-48 bg-linear-surface-1 rounded-2xl shadow-xl border border-linear-hairline py-2 hidden" :class="{'hidden': !open}">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-[#e5484d] hover:bg-[#e5484d]/10 font-medium transition-colors rounded-xl">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-linear-ink hover:text-linear-primary transition-colors">Masuk</a>
                    <!-- Use simple a tag with # if register doesn't exist to prevent route not found -->
                    <a href="{{ Route::has('register') ? route('register') : '#' }}" class="text-sm font-semibold text-white bg-linear-primary hover:bg-linear-primary-hover px-5 py-2.5 rounded-full transition-all hover:-translate-y-0.5">Daftar</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-linear-ink-subtle hover:text-linear-primary transition-colors p-2">
                    <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen"></i>
                    <i data-lucide="x" class="w-6 h-6 hidden" x-show="mobileMenuOpen" :class="{'hidden': !mobileMenuOpen}"></i>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="md:hidden bg-linear-surface-1 border-t border-linear-hairline hidden" x-show="mobileMenuOpen" :class="{'hidden': !mobileMenuOpen}">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('home') ? 'bg-linear-primary/10 text-linear-primary' : 'text-linear-ink-subtle hover:bg-linear-surface-2 hover:text-linear-ink' }}">Beranda</a>
                <a href="{{ route('jobs') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('jobs') ? 'bg-linear-primary/10 text-linear-primary' : 'text-linear-ink-subtle hover:bg-linear-surface-2 hover:text-linear-ink' }}">Lowongan</a>
                <a href="{{ route('cv') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('cv') ? 'bg-linear-primary/10 text-linear-primary' : 'text-linear-ink-subtle hover:bg-linear-surface-2 hover:text-linear-ink' }}">Buat CV</a>
                
                <div class="border-t border-linear-hairline mt-4 pt-4">
                    @auth
                        <a href="{{ route('saved-jobs.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('saved-jobs.index') ? 'bg-linear-primary/10 text-linear-primary' : 'text-linear-ink-subtle hover:bg-linear-surface-2 hover:text-linear-ink' }}">Tersimpan</a>
                        <a href="{{ route('applications.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('applications.index') ? 'bg-linear-primary/10 text-linear-primary' : 'text-linear-ink-subtle hover:bg-linear-surface-2 hover:text-linear-ink' }}">Lamaran Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-base font-medium text-[#e5484d] hover:bg-[#e5484d]/10">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-linear-ink hover:bg-linear-surface-2 hover:text-linear-ink mb-2">Masuk</a>
                        <a href="{{ Route::has('register') ? route('register') : '#' }}" class="block px-4 py-3 rounded-xl text-base font-medium text-center text-white bg-linear-primary hover:bg-linear-primary-hover">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-linear-canvas pt-20 pb-10 border-t border-linear-hairline relative overflow-hidden">
        <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-linear-primary/50 to-transparent"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-linear-primary flex items-center justify-center">
                            <i data-lucide="briefcase" class="text-white w-4 h-4"></i>
                        </div>
                        <span class="text-xl font-bold text-white">LookFor<span class="text-linear-primary">Job</span></span>
                    </div>
                    <p class="text-linear-ink-muted text-sm leading-relaxed max-w-sm mb-8">Platform pencarian kerja modern dan terpercaya. Temukan karier impianmu bersama ribuan perusahaan terbaik di Indonesia.</p>

                </div>
                <div>
                    <h3 class="text-linear-ink font-semibold mb-6">Pencari Kerja</h3>
                    <ul class="space-y-4 text-sm text-linear-ink-subtle">
                        <li><a href="{{ route('jobs') }}" class="hover:text-linear-primary transition-colors">Cari Lowongan</a></li>
                        <li><a href="#" class="hover:text-linear-primary transition-colors">Perusahaan Terbaik</a></li>
                        <li><a href="{{ route('cv') }}" class="hover:text-linear-primary transition-colors">Buat CV Online</a></li>
                        <li><a href="#" class="hover:text-linear-primary transition-colors">Tips Karier</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-linear-ink font-semibold mb-6">Perusahaan</h3>
                    <ul class="space-y-4 text-sm text-linear-ink-subtle">
                        <li><a href="#" class="hover:text-linear-primary transition-colors">Pasang Lowongan</a></li>
                        <li><a href="#" class="hover:text-linear-primary transition-colors">Cari Kandidat</a></li>
                        <li><a href="#" class="hover:text-linear-primary transition-colors">Produk & Harga</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-linear-hairline pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-linear-ink-subtle text-sm">&copy; {{ date('Y') }} LookForJob. Hak Cipta Dilindungi.</p>
                <div class="flex gap-6 text-sm text-linear-ink-subtle">
                    <a href="#" class="hover:text-linear-primary transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-linear-primary transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
    @livewireScripts
</body>
</html>
