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
            Daftar Akun Baru
        </h2>
        <p class="mt-2 text-sm text-slate-600">
            Lengkapi data diri Anda untuk membuat akun baru
        </p>
    </div>

    <!-- Register Card Container -->
    <div class="relative mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 border border-slate-200/80 shadow-md sm:rounded-2xl sm:px-10">
            <!-- Validation Errors -->
            <x-validation-errors class="mb-4" />

            <!-- Register Form -->
            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-1.5">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            autocomplete="name" 
                            required 
                            autofocus 
                            value="{{ old('name') }}"
                            class="block w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition text-sm" 
                            placeholder="John Doe"
                        >
                    </div>
                </div>

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
                            value="{{ old('email') }}"
                            class="block w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition text-sm" 
                            placeholder="nama@email.com"
                        >
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            autocomplete="new-password" 
                            required 
                            class="block w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition text-sm"
                            placeholder="••••••••"
                        >
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1.5">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            autocomplete="new-password" 
                            required 
                            class="block w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition text-sm"
                            placeholder="••••••••"
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit" 
                        class="w-full inline-flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150"
                    >
                        Daftar Akun
                    </button>
                </div>

                <!-- Link to Login -->
                <p class="text-center text-sm text-slate-600 mt-6 pt-4 border-t border-slate-100">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-700 transition-colors">Masuk di sini</a>
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
