@props(['jobs', 'offset' => 0])

@foreach ($jobs as $index => $job)
    <article class="group bg-linear-surface-1 rounded-3xl p-6 border border-linear-hairline shadow-none hover:border-linear-primary/50 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-linear-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row gap-6">
            <!-- Company Logo Placeholder -->
            <div class="w-16 h-16 rounded-2xl bg-linear-surface-2 border border-linear-hairline flex items-center justify-center flex-shrink-0">
                <i data-lucide="building" class="w-8 h-8 text-linear-primary"></i>
            </div>
            
            <div class="flex-1">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-2">
                    <div>
                        <h2 class="text-xl font-bold text-linear-ink mb-1 group-hover:text-linear-primary transition-colors">
                            <a href="{{ route('jobs.detail', ['title' => $job['title'], 'company' => $job['company'], 'location' => $job['location_text'], 'url' => $job['url']]) }}" class="before:absolute before:inset-0">{{ $job['title'] }}</a>
                        </h2>
                        <p class="text-linear-ink-muted font-medium">{{ $job['company'] }}</p>
                    </div>
                    
                    @if(isset($job['is_remote']) && $job['is_remote'])
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-linear-primary/10 text-linear-primary text-xs font-bold whitespace-nowrap self-start">
                            Remote
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-linear-primary/10 text-linear-primary text-xs font-bold whitespace-nowrap self-start">
                            Full Time
                        </span>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-4 text-sm text-linear-ink-subtle mb-4">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        {{ $job['location_text'] }}
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        {{ $job['date_posted'] ?: 'Baru' }}
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="banknote" class="w-4 h-4"></i>
                        Dirahasiakan
                    </div>
                </div>

                <p class="text-linear-ink-muted text-sm leading-relaxed line-clamp-2 mb-6">
                    {{ \Illuminate\Support\Str::limit($job['description'], 150) }}
                </p>
                
                <div class="flex items-center gap-3 relative z-20">
                    <a href="{{ route('jobs.detail', ['title' => $job['title'], 'company' => $job['company'], 'location' => $job['location_text'], 'url' => $job['url']]) }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-linear-surface-2 text-linear-ink font-semibold text-sm hover:bg-linear-primary hover:text-white transition-colors">
                        Lihat Detail
                    </a>
                    
                    @if (!empty($job['company_url']))
                        <a href="{{ $job['company_url'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-linear-surface-2 text-linear-ink-subtle hover:bg-linear-surface-3 hover:text-linear-primary transition-colors tooltip-trigger" title="Website Perusahaan">
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </article>
@endforeach
