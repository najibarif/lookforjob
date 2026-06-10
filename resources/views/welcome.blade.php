<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Look For Job - Temukan Karir Impian</title>
    <meta name="description" content="Platform rekrutmen gaya Neobrutalism untuk mencari pekerjaan dan membuat CV.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback Tailwind CSS for dev -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: { sans: ['Space Grotesk', 'sans-serif'] },
                        boxShadow: { 'brutal': '4px 4px 0px 0px rgba(0,0,0,1)', 'brutal-lg': '8px 8px 0px 0px rgba(0,0,0,1)' },
                        colors: { brutal: { yellow: '#F4E869', pink: '#FF74B1', blue: '#4D96FF', green: '#54BAB9', bg: '#FFF8E1' } }
                    }
                }
            }
        </script>
    @endif
</head>
<body class="font-sans antialiased text-black bg-brutal-bg h-full flex flex-col selection:bg-brutal-pink selection:text-white">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-50 w-full bg-white border-b-4 border-black">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="text-3xl font-black uppercase tracking-tight bg-brutal-yellow px-2 py-1 border-2 border-black shadow-brutal hover:-translate-y-1 hover:shadow-brutal-lg transition-all">
                    LookForJob
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex md:space-x-8 md:items-center font-bold">
                <a href="/jobs" class="text-lg hover:bg-brutal-blue hover:text-white px-3 py-1 border-2 border-transparent hover:border-black transition-all">
                    Cari Lowongan
                </a>
                <a href="/cv" class="text-lg hover:bg-brutal-green hover:text-white px-3 py-1 border-2 border-transparent hover:border-black transition-all">
                    Buat CV
                </a>

                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-brutal-pink text-white border-2 border-black shadow-brutal hover:-translate-y-1 hover:shadow-brutal-lg transition-all">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-white text-black border-2 border-black shadow-brutal hover:bg-brutal-yellow hover:-translate-y-1 hover:shadow-brutal-lg transition-all">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-black text-white border-2 border-black shadow-brutal hover:bg-brutal-pink hover:text-black hover:-translate-y-1 hover:shadow-brutal-lg transition-all">
                            Daftar
                        </a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center py-20 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            
            <!-- Hero Text -->
            <div class="space-y-8">
                <h1 class="text-5xl sm:text-6xl md:text-7xl font-black uppercase leading-[1.1]">
                    Kerja Keras. <br>
                    <span class="bg-brutal-green px-2 border-4 border-black inline-block mt-2 shadow-brutal-lg">Cari Kerja</span> <br>
                    Lebih Cerdas.
                </h1>
                <p class="text-xl font-bold bg-white p-4 border-4 border-black shadow-brutal inline-block">
                    Platform pencarian kerja anti mainstream. <br> Tanpa basa-basi. Tanpa drama.
                </p>
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="/jobs" class="text-xl font-bold uppercase px-8 py-4 bg-brutal-blue text-white border-4 border-black shadow-brutal hover:-translate-y-1 hover:shadow-brutal-lg transition-all">
                        Mulai Cari Kerja
                    </a>
                    <a href="/cv" class="text-xl font-bold uppercase px-8 py-4 bg-brutal-yellow text-black border-4 border-black shadow-brutal hover:-translate-y-1 hover:shadow-brutal-lg transition-all">
                        Bikin CV Instan
                    </a>
                </div>
            </div>

            <!-- Hero Image / Graphic -->
            <div class="relative">
                <div class="absolute inset-0 bg-brutal-pink border-4 border-black shadow-brutal-lg transform translate-x-4 translate-y-4"></div>
                <div class="relative bg-white border-4 border-black p-8 shadow-brutal z-10 flex flex-col gap-6">
                    <div class="flex items-center justify-between border-b-4 border-black pb-4">
                        <div class="text-2xl font-black uppercase">🔥 Lowongan Hot</div>
                        <div class="w-12 h-12 bg-brutal-yellow border-4 border-black rounded-full shadow-brutal"></div>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-brutal-bg border-4 border-black p-4 shadow-brutal hover:-translate-y-1 transition-all cursor-pointer">
                            <h3 class="text-xl font-bold">Frontend Developer</h3>
                            <p class="text-sm font-bold opacity-80">PT. Teknologi Indonesia • Remote</p>
                        </div>
                        <div class="bg-brutal-bg border-4 border-black p-4 shadow-brutal hover:-translate-y-1 transition-all cursor-pointer">
                            <h3 class="text-xl font-bold">Graphic Designer</h3>
                            <p class="text-sm font-bold opacity-80">Studio Kreatif • Jakarta</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white py-10 mt-auto border-t-4 border-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-2xl font-black uppercase tracking-tight bg-white text-black px-2 py-1">
                LookForJob
            </div>
            <p class="text-lg font-bold">
                &copy; {{ date('Y') }} Dibangun dengan brutal.
            </p>
        </div>
    </footer>

</body>
</html>
