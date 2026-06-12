<?php $__env->startSection('title', __('Saved Jobs') . ' - Look For Job'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-slate-50 dark:bg-slate-950 min-h-screen py-10 transition-colors">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-2"><?php echo e(__('Saved Jobs')); ?></h1>
                <p class="text-slate-500 dark:text-slate-400"><?php echo e(__('Manage the list of jobs that interest you.')); ?></p>
            </div>
            <a href="<?php echo e(route('jobs')); ?>" class="inline-flex items-center justify-center px-5 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-sm font-semibold rounded-xl text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors shadow-none">
                <?php echo e(__('Find Other Jobs')); ?>

            </a>
        </div>

        <?php if(session('status')): ?>
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 text-emerald-500 dark:text-emerald-400 border border-transparent flex items-start gap-3">
                <i data-lucide="check-circle-2" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                <div>
                    <h4 class="font-bold text-sm"><?php echo e(__('Information')); ?></h4>
                    <p class="text-sm mt-1"><?php echo e(session('status')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if($savedJobs->isEmpty()): ?>
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-12 text-center shadow-none transition-colors">
                <div class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="bookmark" class="w-10 h-10 text-emerald-500 dark:text-emerald-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2"><?php echo e(__('No saved jobs yet')); ?></h3>
                <p class="text-slate-400 dark:text-slate-500 max-w-md mx-auto mb-6"><?php echo e(__('You haven\'t saved any jobs yet. Start browsing and save jobs that suit you!')); ?></p>
                <a href="<?php echo e(route('jobs')); ?>" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-emerald-500 text-white font-semibold hover:bg-emerald-600 transition-colors shadow-none">
                    <i data-lucide="search" class="w-4 h-4"></i> <?php echo e(__('Browse Jobs')); ?>

                </a>
            </div>
        <?php else: ?>
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-none overflow-hidden transition-colors">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-950/50 border-b border-slate-200 dark:border-slate-800 text-sm font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider transition-colors">
                                <th class="p-6"><?php echo e(__('Position & Company')); ?></th>
                                <th class="p-6"><?php echo e(__('Location')); ?></th>
                                <th class="p-6"><?php echo e(__('Date Saved')); ?></th>
                                <th class="p-6 text-right"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            <?php $__currentLoopData = $savedJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                                    <td class="p-6">
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex flex-shrink-0 items-center justify-center text-xl font-bold text-slate-400 dark:text-slate-500">
                                                <?php echo e(substr($job->company, 0, 1)); ?>

                                            </div>
                                            <div>
                                                <a href="<?php echo e(route('jobs.detail', ['title' => $job->title, 'company' => $job->company, 'location' => $job->location, 'url' => $job->url])); ?>" class="font-bold text-slate-900 dark:text-white mb-1 group-hover:text-emerald-500 dark:group-hover:text-emerald-400 transition-colors block"><?php echo e($job->title); ?></a>
                                                <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                                                    <i data-lucide="building-2" class="w-3.5 h-3.5"></i> <?php echo e($job->company); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <span class="text-sm font-medium text-slate-900 dark:text-white"><?php echo e($job->location ?: '-'); ?></span>
                                    </td>
                                    <td class="p-6">
                                        <span class="text-sm font-medium text-slate-900 dark:text-white"><?php echo e($job->created_at->format('d M Y')); ?></span>
                                        <span class="block text-xs text-slate-400 dark:text-slate-500 mt-1"><?php echo e($job->created_at->format('H:i')); ?></span>
                                    </td>
                                    <td class="p-6 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <form action="<?php echo e(route('saved-jobs.toggle')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="job_id" value="<?php echo e($job->job_id); ?>">
                                                <input type="hidden" name="title" value="<?php echo e($job->title); ?>">
                                                <input type="hidden" name="company" value="<?php echo e($job->company); ?>">
                                                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 dark:hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors" title="Hapus dari tersimpan">
                                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                                </button>
                                            </form>
                                            <a href="<?php echo e(route('jobs.detail', ['title' => $job->title, 'company' => $job->company, 'location' => $job->location, 'url' => $job->url])); ?>" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500/10 text-emerald-500 dark:text-emerald-400 text-sm font-semibold rounded-xl hover:bg-emerald-500 hover:text-white dark:hover:text-white transition-colors">
                                                <?php echo e(__('Apply')); ?> <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if($savedJobs->hasPages()): ?>
                    <div class="p-6 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 transition-colors">
                        <?php echo e($savedJobs->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\LookForJob\resources\views/saved-jobs/index.blade.php ENDPATH**/ ?>