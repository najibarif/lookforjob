<?php $__env->startSection('title', __('My Applications') . ' - Look For Job'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-slate-50 dark:bg-slate-950 min-h-screen py-10 transition-colors">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-2"><?php echo e(__('My Applications')); ?></h1>
                <p class="text-slate-500 dark:text-slate-400"><?php echo e(__('Track the status and history of your job applications.')); ?></p>
            </div>
            <a href="<?php echo e(route('jobs')); ?>" class="inline-flex items-center justify-center px-5 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm font-semibold rounded-xl text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors shadow-none">
                <?php echo e(__('Find Other Jobs')); ?>

            </a>
        </div>

        <?php if($applications->isEmpty()): ?>
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-12 text-center transition-colors shadow-none">
                <div class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="inbox" class="w-10 h-10 text-emerald-500 dark:text-emerald-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2"><?php echo e(__('No applications yet')); ?></h3>
                <p class="text-slate-400 dark:text-slate-500 max-w-md mx-auto mb-6"><?php echo e(__('You haven\'t applied for any jobs on this platform yet. Start finding your dream career now!')); ?></p>
                <a href="<?php echo e(route('jobs')); ?>" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-500 text-white font-semibold hover:bg-emerald-600 transition-colors shadow-none">
                    <i data-lucide="search" class="w-4 h-4"></i> <?php echo e(__('Browse Jobs')); ?>

                </a>
            </div>
        <?php else: ?>
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden transition-colors shadow-none">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-950/50 border-b border-slate-200 dark:border-slate-800 text-sm font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider transition-colors">
                                <th class="p-6"><?php echo e(__('Position & Company')); ?></th>
                                <th class="p-6"><?php echo e(__('Date Applied')); ?></th>
                                <th class="p-6"><?php echo e(__('Status')); ?></th>
                                <th class="p-6 text-right"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                                    <td class="p-6">
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex flex-shrink-0 items-center justify-center text-xl font-bold text-slate-400 dark:text-slate-500">
                                                <?php echo e(substr($app->company_name, 0, 1)); ?>

                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-900 dark:text-white mb-1 group-hover:text-emerald-500 dark:group-hover:text-emerald-400 transition-colors"><?php echo e($app->job_title); ?></h4>
                                                <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                                                    <i data-lucide="building-2" class="w-3.5 h-3.5"></i> <?php echo e($app->company_name); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <span class="text-sm font-medium text-slate-900 dark:text-white"><?php echo e($app->created_at->format('d M Y')); ?></span>
                                        <span class="block text-xs text-slate-400 dark:text-slate-500 mt-1"><?php echo e($app->created_at->format('H:i')); ?></span>
                                    </td>
                                    <td class="p-6">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500/10 text-emerald-500 dark:text-emerald-400 text-xs font-semibold border border-transparent">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span> <?php echo e($app->status); ?>

                                        </span>
                                    </td>
                                    <td class="p-6 text-right">
                                        <a href="<?php echo e($app->job_url); ?>" target="_blank" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-500 dark:text-emerald-400 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors">
                                            <?php echo e(__('View Job')); ?> <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if($applications->hasPages()): ?>
                    <div class="p-6 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 transition-colors">
                        <?php echo e($applications->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\LookForJob\resources\views/applications/index.blade.php ENDPATH**/ ?>