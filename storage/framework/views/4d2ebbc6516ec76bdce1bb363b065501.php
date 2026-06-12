<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['jobs', 'offset' => 0]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['jobs', 'offset' => 0]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $cleanTitle = $job['title'];
    $cleanTitle = trim(preg_replace('/\s*\([mwfdx\s\/]+\)/iu', '', $cleanTitle));
    // Extract salary if present
    $salary = null;
    $parts = explode(' - ', $cleanTitle);
    if (count($parts) > 1) {
        $lastPart = end($parts);
        if (preg_match('/\d+/', $lastPart) && preg_match('/[\x{20AC}\$\x{00A3}]|EUR|USD|Rp/u', $lastPart)) {
            $salary = trim($lastPart);
        }
    }
    if (!$salary && preg_match('/(mindestens\s*)?[\d\.,]+(\s*k)?\s*(\x{20AC}|\$|\x{00A3}|EUR|USD|Rp)/iu', $cleanTitle, $m)) {
        $salary = $m[0];
    }
    $cleanTitle = explode(' - ', $cleanTitle)[0];
    $cleanTitle = explode(' – ', $cleanTitle)[0];
    $cleanTitle = explode(',', $cleanTitle)[0];
    $cleanTitle = explode(' (', $cleanTitle)[0];
    $cleanTitle = trim($cleanTitle);
    
    $cleanDesc = html_entity_decode(strip_tags($job['description']));
?>
    <article class="group bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200 dark:border-slate-800 shadow-none hover:border-emerald-500/50 dark:hover:border-emerald-500/50 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 dark:from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row gap-6">
            <!-- Company Logo Placeholder -->
            <div class="w-16 h-16 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center flex-shrink-0">
                <i data-lucide="building" class="w-8 h-8 text-emerald-500"></i>
            </div>
            
            <div class="flex-1">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-2">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-1 group-hover:text-emerald-500 dark:group-hover:text-emerald-400 transition-colors">
                            <a href="<?php echo e(route('jobs.detail', ['title' => $cleanTitle, 'company' => $job['company'], 'location' => $job['location_text'] ?: $job['location'], 'url' => $job['url']])); ?>" class="before:absolute before:inset-0"><?php echo e($cleanTitle); ?></a>
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400 font-medium"><?php echo e($job['company']); ?></p>
                    </div>
                    
                    <?php if(isset($job['is_remote']) && $job['is_remote']): ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-600/10 dark:bg-emerald-900/30 text-emerald-500 dark:text-emerald-400 text-xs font-bold whitespace-nowrap self-start">
                            <?php echo e(__('Remote')); ?>

                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-600/10 dark:bg-emerald-900/30 text-emerald-500 dark:text-emerald-400 text-xs font-bold whitespace-nowrap self-start">
                            <?php echo e(__('Full Time')); ?>

                        </span>
                    <?php endif; ?>
                </div>

                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 dark:text-slate-400 mb-4">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                        <?php echo e($job['location_text'] ?: $job['location']); ?>

                    </div>
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                        <?php echo e($job['date_posted'] ? (\Carbon\Carbon::parse(is_numeric($job['date_posted']) ? (int)$job['date_posted'] : $job['date_posted'])->diffForHumans()) : __('New')); ?>

                    </div>
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="banknote" class="w-4 h-4"></i>
                        <?php echo e($salary ? $salary : __('Confidential')); ?>

                    </div>
                </div>

                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed line-clamp-2 mb-6">
                    <?php echo e(\Illuminate\Support\Str::limit($cleanDesc, 150)); ?>

                </p>
                
                <div class="flex items-center gap-3 relative z-20">
                    <a href="<?php echo e(route('jobs.detail', ['title' => $cleanTitle, 'company' => $job['company'], 'location' => $job['location_text'] ?: $job['location'], 'url' => $job['url']])); ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-semibold text-sm hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 transition-colors">
                        <?php echo e(__('View Details')); ?>

                    </a>
                    
                    <?php if(!empty($job['company_url'])): ?>
                        <a href="<?php echo e($job['company_url']); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors tooltip-trigger" title="<?php echo e(__('Company Website')); ?>">
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </article>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\xampp\htdocs\LookForJob\resources\views/jobs/partials/job-cards.blade.php ENDPATH**/ ?>