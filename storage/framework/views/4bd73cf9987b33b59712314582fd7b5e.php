

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="<?php echo e(route('admin.abstracts')); ?>" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back
        </a>
    </div>

    <!-- Document Header -->
    <div class="bg-white shadow overflow-hidden mb-6">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex flex-col">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900"><?php echo e($submission->title); ?></h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Serial Number: <?php echo e($submission->serial_number); ?></p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold <?php echo e($submission->score === null ? 'bg-yellow-300 text-gray-800' :
                        ($submission->score ? 'bg-green-300 text-gray-800' : 'bg-gray-300 text-gray-800')); ?>">
                        <?php echo e($submission->score === null ? 'Pending' : 
                            ($submission->score ? 'Completed' : 'Incomplete')); ?>

                    </span>
                </div>
                <div class="self-start">
                <?php if($submission->pdf_path == null): ?>
                    <a href = "<?php echo e(route('request.article.upload', ['serial_number' => $submission->serial_number])); ?>" class="px-6 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-9.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Request Document Upload
                    </a>
                <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Document Details -->
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Submitted by</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?php echo e($submission->user_reg_no); ?></dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Submission Date</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <?php echo e(date('F j, Y', strtotime($submission->created_at))); ?>

                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Score</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="<?php echo e($submission->score === null ? 'bg-yellow-200 text-gray-800 p-2 rounded-md' : 'text-gray-900'); ?>">
                            <?php echo e($submission->score ?? 'Not reviewed yet'); ?>

                        </span>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Reviewers Section -->
    <div class="bg-white shadow overflow-hidden mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Assigned Reviewers</h3>
        </div>
        <div class="border-t border-gray-200">
            <ul class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $submission->reviewers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviewer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="px-4 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900"><?php echo e($reviewer->first_name); ?> <?php echo e($reviewer->last_name); ?></p>
                            <p class="text-sm text-gray-500"><?php echo e($reviewer->reg_no); ?></p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs <?php echo e($reviewer->pivot->status === 'accepted' ? 'bg-green-300 text-grey-800' : 'bg-yellow-300 text-grey-800'); ?>">
                            <?php echo e(ucfirst($reviewer->pivot->status)); ?>

                        </span>
                    </div>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="px-4 py-4">
                    <p class="text-sm text-gray-700 bg-yellow-100 p-2 rounded-md">
                        No reviewers assigned yet
                    </p>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Document Preview -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-semibold text-gray-900">Document Preview</h3>
        <div class="mt-4 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 items-center">
            <?php if($submission->pdf_path): ?>
                <a href="<?php echo e(asset('storage/' . $submission->pdf_path)); ?>" target="_blank" 
                   class="flex items-center text-blue-600 hover:text-blue-800 w-full sm:w-auto">
                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span class="whitespace-nowrap">View Article</span>
                </a>
            <?php else: ?>
                <p class="text-gray-500 italic">Article not available</p>
            <?php endif; ?>
            <a href="<?php echo e(route('research.abstract.download', ['serial_number' => $submission->serial_number])); ?>" 
               class="flex items-center text-blue-600 hover:text-blue-800 w-full sm:w-auto">
                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span class="whitespace-nowrap">Download (PDF)</span>
            </a>
            <a href="<?php echo e(route('abstract.abstractWord.download', ['serial_number' => $submission->serial_number])); ?>" 
               class="flex items-center text-blue-600 hover:text-blue-800 w-full sm:w-auto">
                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span class="whitespace-nowrap">Download (Word)</span>
            </a>
        </div>
    </div>
    
    <div class="p-4 sm:p-6 flex justify-end">
        <form action="<?php echo e(route('approve.abstract', ['serial_number' => $submission->serial_number])); ?>" method="POST" class="w-full sm:w-auto">
            <?php echo csrf_field(); ?>
            <button type="submit" class="w-full sm:w-auto px-4 sm:px-6 py-2 rounded-md bg-green-500 text-white font-semibold hover:bg-green-600 transition-colors flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Approve
            </button>
        </form>
    </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any necessary JavaScript functionality here
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/admin/partials/abstract_details.blade.php ENDPATH**/ ?>