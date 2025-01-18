

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <!-- Progress Tracker Container -->
        <div class="max-w-4xl mx-auto mb-8">
            <div class="relative">
                <!-- Progress Bar Background -->
                <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
                <!-- Active Progress Bar -->
                <div class="absolute top-1/2 left-0 w-3/4 h-1 bg-green-500 -translate-y-1/2 transition-all duration-500"></div>

                <!-- Progress Steps -->
                <div class="relative flex justify-between">
                    <?php $__currentLoopData = ['Authors', 'Abstract', 'Preview', 'Confirm']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 <?php echo e($index < 2 ? 'bg-green-500' : ($index == 2 ? 'bg-green-500 ring-4 ring-green-100' : 'bg-gray-200')); ?> 
                                rounded-full flex items-center justify-center <?php echo e($index < 3 ? 'text-white' : 'text-gray-600'); ?> font-semibold mb-2 <?php echo e($index < 2 ? 'shadow-lg' : ''); ?>">
                                <?php if($index < 2): ?>
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                <?php else: ?>
                                    <?php echo e($index + 1); ?>

                                <?php endif; ?>
                            </div>
                            <span class="text-sm font-medium <?php echo e($index < 3 ? 'text-green-600' : 'text-gray-500'); ?>"><?php echo e($step); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

<!-- Main Content -->
<div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-lg overflow-hidden rounded-lg">
            <!-- Form Header - Responsive text sizes -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-4 sm:px-8 py-4 sm:py-6">
                <h2 class="text-xl sm:text-2xl font-bold text-white">Abstract Preview</h2>
                <p class="text-green-100 text-xs sm:text-sm mt-2">Please preview the details of your abstract submission</p>
            </div>

            <form id="previewForm" action="<?php echo e(route('submit.preview')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="bg-gray-50 p-4 sm:p-6 border border-gray-800">
                    <!-- Title - Responsive text sizing -->
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center mb-2 break-words">
                        <?php echo e($article_title ?? 'Untitled'); ?>

                    </h1>

                    <!-- Authors Section - Responsive padding and text -->
                    <div class="p-4 sm:p-8">
                        <h1 class="text-base sm:text-lg font-bold text-gray-900 text-center mb-2 break-words">
                            <?php if(isset($allAuthors) && is_array($allAuthors)): ?>
                                <?php echo e(implode(', ', array_map(fn($author) => $author['first_name'] . ' ' . ($author['middle_name'] ?? '') . ' ' . $author['surname'] . (isset($author['is_correspondent']) && $author['is_correspondent'] ? '*' : ''), $allAuthors))); ?>

                            <?php endif; ?>
                        </h1>
                        
                        <!-- Universities - Responsive text -->
                        <h2 class="text-base sm:text-lg font-medium text-gray-700 text-center mt-2 break-words">
                            <?php if(isset($allAuthors) && is_array($allAuthors)): ?>
                                <?php echo e(implode(', ', array_map(fn($author) => $author['university'], $allAuthors))); ?>

                            <?php endif; ?>
                        </h2>
                        
                        <!-- Departments - Responsive text -->
                        <h3 class="text-sm sm:text-base text-gray-600 text-center mt-2 break-words">
                            <?php if(isset($allAuthors) && is_array($allAuthors)): ?>
                                <?php echo e(implode(', ', array_map(fn($author) => $author['department'], $allAuthors))); ?>

                            <?php endif; ?>
                        </h3>
                    </div>

                    <!-- Abstract Section - Responsive spacing -->
                    <div class="p-4 sm:p-8">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Abstract</h2>
                        <p class="text-sm sm:text-base text-gray-700 leading-relaxed break-words">
                            <?php echo e($abstract['abstract'] ?? 'No abstract provided.'); ?>

                        </p>
                    </div>

                    <!-- Keywords Section -->
                    <div class="p-4 sm:p-8">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Keywords</h2>
                        <p class="text-sm sm:text-base text-gray-700 leading-relaxed break-words">
                            <?php echo e(isset($abstract['keywords']) ? implode(', ', $abstract['keywords']) : 'No keywords provided.'); ?>

                        </p>
                    </div>

                    <!-- Sub-Theme Section -->
                    <div class="p-4 sm:p-8">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Sub-Theme</h2>
                        <p class="text-sm sm:text-base text-gray-700 leading-relaxed break-words">
                            <?php echo e($abstract['sub_theme'] ?? 'No sub-theme selected.'); ?>

                        </p>
                    </div>
                </div>

                <!-- Action Buttons - Responsive layout -->
                <div class="mt-4 sm:mt-8 p-4 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <a href="<?php echo e(route('user.step2')); ?>" 
                        class="w-full sm:w-auto px-4 sm:px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Previous
                    </a>

                    <button type="button" onclick="openModal()" 
                        class="w-full sm:w-auto px-4 sm:px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 flex items-center justify-center">
                        Continue
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirmation Modal - Responsive design -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 w-full max-w-md mx-auto">
        <!-- Modal Content -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-12 sm:w-16 h-12 sm:h-16 bg-green-100 rounded-full mb-4">
                <svg class="w-6 sm:w-8 h-6 sm:h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2">Ready for Submission</h3>
        </div>

        <!-- Important Notes - Responsive spacing -->
        <div class="space-y-3 sm:space-y-4 border-t border-gray-200 pt-4 sm:pt-6">
            <!-- Review Process -->
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 sm:w-6 h-5 sm:h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-gray-800">Review Process</h4>
                    <p class="text-xs sm:text-sm text-gray-600">Your abstract will be reviewed. You will be notified of the decision via email.</p>
                </div>
            </div>

            <!-- Important Notice -->
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 sm:w-6 h-5 sm:h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-gray-800">Important Notice</h4>
                    <p class="text-xs sm:text-sm text-gray-600">Once submitted, you cannot make changes to your abstract. Please ensure all details are correct.</p>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 sm:w-6 h-5 sm:h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-gray-800">Next Steps</h4>
                    <p class="text-xs sm:text-sm text-gray-600">After acceptance, you will be notified to submit your full article through the system.</p>
                </div>
            </div>
        </div>

        <!-- Modal Buttons - Responsive layout -->
        <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
            <button type="button" onclick="closeModal()" 
                class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 text-sm">
                Cancel
            </button>
            <button type="submit" form="previewForm" 
                class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                Confirm
            </button>
        </div>
    </div>
</div>

<!-- JavaScript for Modal Control -->
<script>
    function openModal() {
        document.getElementById('confirmationModal').classList.remove('hidden');
        // Prevent background scrolling
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
        // Re-enable background scrolling
        document.body.style.overflow = 'auto';
    }

    // Close modal on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    // Close modal on outside click
    document.getElementById('confirmationModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeModal();
        }
    });


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/user/partials/preview.blade.php ENDPATH**/ ?>