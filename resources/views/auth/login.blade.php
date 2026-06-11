<x-guest-layout>
<div class="relative min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Background Gradient Accents -->
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-emerald-200/30 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full bg-teal-200/20 blur-3xl"></div>
    </div>

    <!-- Header / Brand -->
    <div class="relative sm:mx-auto sm:w-full sm:max-w-md text-center">
        <a href="{{ url('/') }}" class="inline-block text-3xl font-extrabold text-emerald-600 hover:text-emerald-700 transition focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-md py-1">
            Look For Job
        </a>
        <h2 class="mt-6 text-2xl font-extrabold text-slate-900">
            Masuk ke Akun Anda
        </h2>
        <p class="mt-2 text-sm text-slate-600">
            Silakan masukkan kredensial Anda untuk melanjutkan
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
                            class="block w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition text-sm" 
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
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded-sm">
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
                            class="block w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition text-sm"
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
                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded transition"
                    >
                    <label for="remember_me" class="ml-2 block text-sm font-medium text-slate-600 select-none">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit" 
                        class="w-full inline-flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150"
                    >
                        Masuk
                    </button>
                </div>

                <!-- Link to Register -->
                <p class="text-center text-sm text-slate-600 mt-6 pt-4 border-t border-slate-100">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700 transition-colors">Daftar sekarang</a>
                </p>
            </form>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-8">
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-slate-200 text-sm font-semibold rounded-full text-slate-700 hover:bg-slate-50 hover:text-emerald-700 transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
</x-guest-layout>