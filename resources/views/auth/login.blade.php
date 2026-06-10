<x-guest-layout>
<div class="relative min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Background Gradient Accents -->
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-indigo-200/30 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full bg-violet-200/20 blur-3xl"></div>
    </div>

    <!-- Header / Brand -->
    <div class="relative sm:mx-auto sm:w-full sm:max-w-md text-center">
        <a href="{{ url('/') }}" class="inline-block text-3xl font-extrabold bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent hover:opacity-90 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-md py-1">
            Look For Job
        </a>
        <h2 class="mt-6 text-2xl font-extrabold text-slate-900">
            Masuk ke Akun Anda
        </h2>
        <p class="mt-2 text-sm text-slate-600">
            Atau
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-sm">
                daftar akun baru di sini
            </a>
        </p>
    </div>

    <!-- Login Card Container -->
    <div class="relative mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 border border-slate-200/80 shadow-md sm:rounded-2xl sm:px-10">
            <!-- Validation Errors and Status Messages -->
            <x-validation-errors class="mb-4" />

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600" role="alert">
                    {{ $value }}
                </div>
            @endsession

            <!-- Login Form -->
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="username" 
                            required 
                            autofocus 
                            value="{{ old('email') }}"
                            class="block w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition text-sm" 
                            placeholder="nama@email.com"
                        >
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-bold text-slate-700">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-sm">
                                Lupa Password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            autocomplete="current-password" 
                            required 
                            class="block w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition text-sm"
                            placeholder="••••••••"
                        >
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center">
                    <input 
                        id="remember_me" 
                        name="remember" 
                        type="checkbox" 
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded transition"
                    >
                    <label for="remember_me" class="ml-2 block text-sm font-medium text-slate-600 select-none">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit" 
                        class="w-full inline-flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150"
                    >
                        Masuk
                    </button>
                </div>
            </form>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="inline-flex items-center text-xs font-semibold text-slate-500 hover:text-indigo-600 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-sm">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
</x-guest-layout>