@extends('layouts.main')

@section('title', __('AI Resume Builder') . ' - LookForJob')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-emerald-50 dark:from-emerald-950/40 via-white dark:via-slate-950 to-teal-50 dark:to-teal-950/40 py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-700 dark:text-emerald-400">
                    <i data-lucide="file-text" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-slate-900 dark:text-white">{{ __('AI Resume Builder') }}</h1>
                    <p class="text-slate-600 dark:text-slate-400 mt-2">{{ __('Create a professional, ATS-friendly resume in minutes') }}</p>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Form Section -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-800 p-8">
                    <form id="resumeForm" class="space-y-6">
                        @csrf

                        <!-- Job Title -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">
                                {{ __('Job Title') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="job_title" placeholder="e.g., Senior Frontend Developer" 
                                   class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-900 dark:text-white"
                                   required>
                        </div>

                        <!-- Skills -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">
                                {{ __('Skills') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea name="skills" rows="4" placeholder="Enter your skills separated by commas (e.g., JavaScript, React, Node.js)"
                                      class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-900 dark:text-white"
                                      required></textarea>
                        </div>

                        <!-- Experience -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">
                                {{ __('Professional Experience') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea name="experience" rows="4" placeholder="Describe your work experience and achievements"
                                      class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-900 dark:text-white"
                                      required></textarea>
                        </div>

                        <!-- Tone -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">
                                {{ __('Writing Tone') }}
                            </label>
                            <select name="tone" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 text-slate-900 dark:text-white">
                                <option value="professional">{{ __('Professional') }}</option>
                                <option value="casual">{{ __('Casual') }}</option>
                                <option value="creative">{{ __('Creative') }}</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-lg transition-all shadow-md shadow-emerald-500/20 flex items-center justify-center gap-2">
                            <i data-lucide="magic-wand-2" class="w-5 h-5"></i>
                            {{ __('Generate Resume') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Preview Section -->
            <div>
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-800 p-8 sticky top-24">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">{{ __('Preview') }}</h3>
                    <div id="preview" class="space-y-3 text-sm text-slate-600 dark:text-slate-400">
                        <p class="text-center text-slate-400 dark:text-slate-500">{{ __('Your resume will appear here') }}</p>
                    </div>

                    <!-- Download Button -->
                    <button id="downloadBtn" disabled class="w-full mt-6 bg-emerald-700 hover:bg-emerald-600 disabled:opacity-50 disabled:cursor-not-allowed text-white font-semibold py-2 px-4 rounded-lg transition-all flex items-center justify-center gap-2">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        {{ __('Download PDF') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('resumeForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(document.getElementById('resumeForm'));
        const data = Object.fromEntries(formData);

        try {
            const response = await fetch('/ajax/generate-resume', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.success) {
                document.getElementById('preview').innerHTML = `<pre class="bg-slate-50 dark:bg-slate-800 p-4 rounded whitespace-pre-wrap text-xs">${result.resume}</pre>`;
                document.getElementById('downloadBtn').disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
</script>
@endsection
