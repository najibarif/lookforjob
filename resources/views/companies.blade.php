@extends('layouts.main')

@section('title', __('Companies') . ' - Look For Job')

@section('content')
<div class="bg-slate-50 dark:bg-slate-950 min-h-screen py-20 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white mb-4">{{ __('Browse Companies') }}</h1>
        <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto mb-12">{{ __('Discover great places to work and find the perfect company culture for your next career move.') }}</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-8 transition-colors hover:shadow-xl hover:-translate-y-1 duration-300">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold text-slate-400">T</div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Tech Innovators</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6">Jakarta, Indonesia</p>
                <a href="#" class="text-emerald-500 dark:text-emerald-400 font-semibold hover:underline">{{ __('View Profile') }}</a>
            </div>
            
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-8 transition-colors hover:shadow-xl hover:-translate-y-1 duration-300">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold text-slate-400">C</div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Creative Studio</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6">Bandung, Indonesia</p>
                <a href="#" class="text-emerald-500 dark:text-emerald-400 font-semibold hover:underline">{{ __('View Profile') }}</a>
            </div>
            
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-8 transition-colors hover:shadow-xl hover:-translate-y-1 duration-300">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl font-bold text-slate-400">G</div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Global Finance</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6">Singapore</p>
                <a href="#" class="text-emerald-500 dark:text-emerald-400 font-semibold hover:underline">{{ __('View Profile') }}</a>
            </div>
        </div>
        
        <div class="mt-12">
            <p class="text-slate-500 dark:text-slate-400">{{ __('More companies coming soon.') }}</p>
        </div>
    </div>
</div>
@endsection
