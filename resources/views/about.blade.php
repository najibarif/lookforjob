@extends('layouts.main')

@section('title', __('About Us') . ' - Look For Job')

@section('content')
<div class="bg-slate-50 dark:bg-slate-950 min-h-screen py-20 transition-colors">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="w-20 h-20 rounded-2xl bg-emerald-500 flex items-center justify-center shadow-lg shadow-emerald-500/20 mx-auto mb-8">
            <i data-lucide="briefcase" class="text-white w-10 h-10"></i>
        </div>
        <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white mb-6">{{ __('About') }} LookFor<span class="text-emerald-500">Job</span></h1>
        <p class="text-lg text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
            {{ __('LookForJob is a modern platform designed to connect talented professionals with the best companies. We believe that finding a job should be easy, transparent, and empowering.') }}
        </p>
        <p class="text-lg text-slate-600 dark:text-slate-400 mb-12 leading-relaxed">
            {{ __('With our AI-powered resume generator and curated job listings, we help you take the next big step in your career with confidence.') }}
        </p>
        <a href="{{ route('jobs') }}" class="inline-flex items-center justify-center px-8 py-3 bg-emerald-500 text-white rounded-xl font-semibold hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-500/20">
            {{ __('Start Searching Jobs') }}
        </a>
    </div>
</div>
@endsection
