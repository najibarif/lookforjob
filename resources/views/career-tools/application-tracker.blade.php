@extends('layouts.main')

@section('title', __('Application Tracker') . ' - LookForJob')

@section('content')
<section class="min-h-screen bg-gradient-to-br from-emerald-50 dark:from-emerald-950/40 via-white dark:via-slate-950 to-teal-50 dark:to-teal-950/40 py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-12">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-700 dark:text-emerald-400">
                    <i data-lucide="clipboard-list" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-bold text-slate-900 dark:text-white">{{ __('Application Tracker') }}</h1>
                    <p class="text-slate-600 dark:text-slate-400 mt-2">{{ __('Track all your job applications in one place') }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
            @php
                $statuses = [
                    ['label' => __('Total'), 'value' => $stats['total'], 'color' => 'emerald'],
                    ['label' => __('Applied'), 'value' => $stats['applied'], 'color' => 'blue'],
                    ['label' => __('Shortlisted'), 'value' => $stats['shortlisted'], 'color' => 'yellow'],
                    ['label' => __('Interviewed'), 'value' => $stats['interviewed'], 'color' => 'purple'],
                    ['label' => __('Offered'), 'value' => $stats['offered'], 'color' => 'green'],
                    ['label' => __('Rejected'), 'value' => $stats['rejected'], 'color' => 'red'],
                ];
            @endphp

            @foreach($statuses as $stat)
                <div class="bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-slate-100 dark:border-slate-800 p-4">
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-bold text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 mt-2">{{ $stat['value'] }}</p>
                </div>
            @endforeach
        </div>

        <!-- Applications Table -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-800 overflow-hidden">
            @if($applications->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900 dark:text-white">{{ __('Job Title') }}</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900 dark:text-white">{{ __('Company') }}</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900 dark:text-white">{{ __('Status') }}</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900 dark:text-white">{{ __('Applied Date') }}</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900 dark:text-white">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach($applications as $app)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $app->job_title }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $app->company_name }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <select class="status-select px-3 py-1 rounded-full text-xs font-semibold border-0 cursor-pointer" data-app-id="{{ $app->id }}"
                                                data-current="{{ $app->status }}">
                                            <option value="applied" {{ $app->status === 'applied' ? 'selected' : '' }}>{{ __('Applied') }}</option>
                                            <option value="shortlisted" {{ $app->status === 'shortlisted' ? 'selected' : '' }}>{{ __('Shortlisted') }}</option>
                                            <option value="interviewed" {{ $app->status === 'interviewed' ? 'selected' : '' }}>{{ __('Interviewed') }}</option>
                                            <option value="offered" {{ $app->status === 'offered' ? 'selected' : '' }}>{{ __('Offered') }}</option>
                                            <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $app->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ $app->job_url }}" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                            {{ __('View') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <i data-lucide="inbox" class="w-16 h-16 text-slate-300 dark:text-slate-700 mx-auto mb-4"></i>
                    <p class="text-slate-600 dark:text-slate-400">{{ __('No applications yet. Start applying to jobs!') }}</p>
                </div>
            @endif
        </div>
    </div>
</section>

<script>
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', async (e) => {
            const appId = e.target.dataset.appId;
            const newStatus = e.target.value;

            try {
                const response = await fetch(`/ajax/applications/${appId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || '',
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                if (!response.ok) throw new Error('Failed to update status');
                
                // Update visual feedback
                e.target.classList.add('ring-2', 'ring-emerald-500');
                setTimeout(() => {
                    e.target.classList.remove('ring-2', 'ring-emerald-500');
                }, 1000);
            } catch (error) {
                console.error('Error:', error);
                e.target.value = e.target.dataset.current;
            }
        });
    });
</script>
@endsection
