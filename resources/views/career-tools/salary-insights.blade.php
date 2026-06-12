@extends('layouts.main')

@section('title', __('Salary Insights') . ' - LookForJob')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-emerald-50 dark:from-emerald-950/40 via-white dark:via-slate-950 to-teal-50 dark:to-teal-950/40 py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-700 dark:text-emerald-400">
                    <i data-lucide="trending-up" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-slate-900 dark:text-white">{{ __('Salary Insights') }}</h1>
                    <p class="text-slate-600 dark:text-slate-400 mt-2">{{ __('Discover market salary data to negotiate confidently') }}</p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Search Section -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-800 p-8 sticky top-24">
                    <form id="salaryForm" class="space-y-6">
                        @csrf

                        <!-- Job Title -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">
                                {{ __('Job Title') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="job_title" placeholder="e.g., Product Manager" 
                                   class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-900 dark:text-white"
                                   required>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">
                                {{ __('Location') }}
                            </label>
                            <input type="text" name="location" placeholder="e.g., Jakarta, Indonesia" 
                                   class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-900 dark:text-white">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-lg transition-all shadow-md shadow-emerald-500/20 flex items-center justify-center gap-2">
                            <i data-lucide="search" class="w-5 h-5"></i>
                            {{ __('Get Insights') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Results Section -->
            <div class="lg:col-span-2">
                <div id="resultsContainer"></div>
                <div id="emptyState" class="bg-white dark:bg-slate-900 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-800 p-12 text-center">
                    <i data-lucide="pie-chart" class="w-16 h-16 text-slate-300 dark:text-slate-700 mx-auto mb-4"></i>
                    <p class="text-slate-600 dark:text-slate-400">{{ __('Search for a job title to see salary insights') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('salaryForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(document.getElementById('salaryForm'));
        const data = Object.fromEntries(formData);
        const submitBtn = document.querySelector('#salaryForm button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.innerHTML = `<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Loading AI Insights...`;
        submitBtn.disabled = true;

        try {
            const response = await fetch('/ajax/salary-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
            lucide.createIcons();

            if (result.success) {
                const resultsDiv = document.getElementById('resultsContainer');
                resultsDiv.innerHTML = `
                    <div class="space-y-4 animate-fade-in-up">
                        <!-- Average Salary -->
                        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-800 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('Average Salary') }}</p>
                                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">${result.data.average_salary}</p>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-700 dark:text-emerald-400">
                                    <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Salary Range -->
                        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-800 p-6">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">{{ __('Salary Range by Experience') }}</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('Entry Level') }}</span>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">${result.data.salary_range.entry_level}</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('Mid Level') }}</span>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">${result.data.salary_range.mid_level}</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-slate-50 dark:bg-slate-800 rounded-lg">
                                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('Senior Level') }}</span>
                                    <span class="text-sm font-bold text-slate-900 dark:text-white">${result.data.salary_range.senior_level}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Top Skills -->
                        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-800 p-6">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">{{ __('Top Required Skills') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                ${result.data.top_skills.map(skill => `
                                    <span class="px-4 py-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 text-sm font-medium rounded-full">
                                        ${skill}
                                    </span>
                                `).join('')}
                            </div>
                        </div>

                        <!-- Market Info -->
                        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-800 p-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('Market Demand') }}</p>
                                    <p class="text-2xl font-bold text-slate-900 dark:text-white mt-2">${result.data.market_demand.high}%</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-500 mt-1">{{ __('High Demand') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ __('Job Growth') }}</p>
                                    <p class="text-2xl font-bold text-slate-900 dark:text-white mt-2">${result.data.job_growth}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-500 mt-1">{{ __('Annually') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('emptyState').classList.add('hidden');
            } else {
                alert(result.message || 'Gagal mengambil data dari AI. Pastikan API Key valid.');
            }
        } catch (error) {
            console.error('Error:', error);
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
            lucide.createIcons();
            alert('Gagal mengambil data dari AI. Silakan coba lagi.');
        }
    });
</script>
@endsection
