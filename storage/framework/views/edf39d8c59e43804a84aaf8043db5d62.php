

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Progress Tracker -->
    <div class="max-w-4xl mx-auto mb-8 px-4">
        <div class="relative">
            <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
            <div class="absolute top-1/2 left-0 w-3/4 h-1 bg-green-500 -translate-y-1/2 transition-all duration-500"></div>

            <div class="relative flex justify-between">
                <?php $__currentLoopData = ['Authors', 'Abstract', 'Preview', 'Confirm']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 <?php echo e($index < 2 ? 'bg-green-500' : ($index == 2 ? 'bg-green-500 ring-4 ring-green-100' : 'bg-gray-200')); ?> 
                            rounded-full flex items-center justify-center <?php echo e($index < 3 ? 'text-white' : 'text-gray-600'); ?> font-semibold mb-2 <?php echo e($index < 2 ? 'shadow-lg' : ''); ?>">
                            <?php if($index < 2): ?>
                                <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            <?php else: ?>
                                <?php echo e($index + 1); ?>

                            <?php endif; ?>
                        </div>
                        <span class="text-xs sm:text-sm font-medium <?php echo e($index < 3 ? 'text-green-600' : 'text-gray-500'); ?>"><?php echo e($step); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto">
        <form 
            action="<?php echo e(route('submit.preview_research')); ?>"
            enctype="multipart/form-data"
            method="POST"
            id="previewForm">
            <?php echo csrf_field(); ?>
            <div class="bg-white shadow-lg overflow-hidden rounded-lg">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-4 sm:px-8 py-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-white">Preview Submission</h2>
                    <p class="text-green-100 text-xs sm:text-sm mt-2">Review your submission details before proceeding.</p>
                </div>

                <div class="flex flex-col lg:flex-row">
                    <!-- Left Column -->
                    <div class="w-full lg:w-1/2 p-4 sm:p-6 border-b lg:border-b-0 lg:border-r border-gray-200">
                        <div class="bg-grey-50 space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Abstract Details</h3>
                                <div class="rounded-lg p-4">
                                    <div class="space-y-4">
                                        <div class="p-4 sm:p-8">
                                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center mb-2">
                                                <?php echo e($articleTitle ?? 'Untitled'); ?>

                                            </h1>
                                            <div class="p-4 sm:p-8">
                                                <!-- Authors -->
                                                <h1 class="text-lg sm:text-xl font-bold text-gray-900 text-center mb-2">
                                                    <?php if(isset($authorData) && is_array($authorData)): ?>
                                                        <?php echo e(implode(', ', array_map(fn($author) => $author['first_name'] . ' ' . ($author['middle_name'] ?? '') . ' ' . $author['surname'] . (isset($author['is_correspondent']) && $author['is_correspondent'] ? '*' : ''), $authorData))); ?>

                                                    <?php endif; ?>
                                                </h1>
                                                
                                                <!-- Universities -->
                                                <h2 class="text-base sm:text-lg font-medium text-gray-700 text-center">
                                                    <?php if(isset($authorData) && is_array($authorData)): ?>
                                                        <?php echo e(implode(', ', array_map(fn($author) => $author['university'], $authorData))); ?>

                                                    <?php endif; ?>
                                                </h2>
                                                
                                                <!-- Departments -->
                                                <h3 class="text-sm sm:text-md text-gray-600 text-center">
                                                    <?php if(isset($authorData) && is_array($authorData)): ?>
                                                        <?php echo e(implode(', ', array_map(fn($author) => $author['department'], $authorData))); ?>

                                                    <?php endif; ?>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-lg p-2">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Abstract</h3>
                                        <div class="prose max-w-none text-sm sm:text-base">
                                            <?php echo e($abstract); ?>

                                        </div>
                                    </div>

                                    <div class="space-y-4 mt-4">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 font-semibold">Title</h4>
                                            <p class="mt-1 text-sm sm:text-base text-gray-900"><?php echo e($articleTitle); ?></p>
                                            <input type="hidden" name="article_title" value="<?php echo e($articleTitle); ?>">
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 font-semibold">Sub-Theme</h4>
                                            <p class="mt-1 text-sm sm:text-base text-gray-900"><?php echo e($subTheme); ?></p>
                                            <input type="hidden" name="sub_theme" value="<?php echo e($subTheme); ?>">
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-800 font-semibold">Keywords</h4>
                                            <div class="mt-1 flex flex-wrap gap-2 text-sm sm:text-base">
                                                <?php if(is_array($keywords) && count($keywords) > 0): ?>
                                                    <?php echo e(implode(', ', $keywords)); ?>

                                                <?php else: ?>
                                                    No keywords provided
                                                <?php endif; ?>
                                                <?php $__currentLoopData = $keywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <input type="hidden" name="keywords[]" value="<?php echo e($keyword); ?>">
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                        <div class="mt-4 text-xs sm:text-sm text-gray-500">
                                            Word count: <?php echo e(str_word_count($abstract)); ?>

                                        </div>
                                        <input type="hidden" name="abstract" value="<?php echo e($abstract); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="w-full lg:w-1/2 p-4 sm:p-6 flex flex-col">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Document Preview</h3>
                        <div id="documentPreviewContainer" class="bg-gray-50 rounded-lg flex-1 min-h-[400px] lg:min-h-[600px] relative">
                            <div id="loadingIndicator" class="hidden absolute inset-0 flex items-center justify-center bg-gray-50 bg-opacity-75">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600"></div>
                            </div>
                            <div id="previewContent" class="w-full h-full">
                                <?php if($documentPath): ?>
                                    <?php if(pathinfo($documentPath, PATHINFO_EXTENSION) === 'pdf'): ?>
                                        <embed src="<?php echo e(asset('storage/research_proposals/' . basename($documentPath))); ?>" 
                                               type="application/pdf" 
                                               class="w-full h-full rounded-lg" 
                                               id="pdfViewer">
                                    <?php else: ?>
                                        <p class="text-gray-500 p-4">No preview available for this file type</p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p class="text-gray-500 p-4">No document uploaded</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="<?php echo e(route('user.step2_research')); ?>" 
                           class="w-full sm:w-auto px-6 py-2 border border-gray-300 rounded-md text-center text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400">
                            Previous
                        </a>
                        <a href="<?php echo e(route('user.downloadAbstractPdf')); ?>"
                           class="w-full sm:w-auto px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                            Download Abstract as PDF
                        </a>
                        <button type="button" 
                                onclick="openModal()" 
                                class="w-full sm:w-auto px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 flex items-center justify-center">
                            Continue
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Responsive Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-auto">
        <!-- Modal Content -->
        <div class="p-4 sm:p-6">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-green-100 rounded-full mb-4">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2">Ready for Submission</h3>
            </div>

            <!-- Important Notes -->
            <div class="space-y-4 border-t border-gray-200 pt-4 sm:pt-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-gray-800">Review Process</h4>
                        <p class="text-xs sm:text-sm text-gray-600">Your abstract will be reviewed. You will be notified of the decision via email.</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-gray-800">Important Notice</h4>
                        <p class="text-xs sm:text-sm text-gray-600">Once submitted, you cannot make changes to your abstract. Please ensure all details are correct.</p>
                    </div>
                </div>
            </div>

            <!-- Modal Buttons -->
            <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
            <button type="button" 
                        onclick="closeModal()" 
                        class="w-full sm:w-auto px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors duration-200">
                    Cancel
                </button>
                <button type="submit" 
                        form="previewForm" 
                        class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const documentPath = "<?php echo e($documentPath); ?>";
    const previewContainer = document.getElementById('documentPreviewContainer');
    const pdfViewer = document.getElementById('pdfViewer');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const modal = document.getElementById('confirmationModal');

    // Initialize PDF viewer with responsive height
    if (pdfViewer) {
        initializePdfViewer();
        window.addEventListener('resize', initializePdfViewer);
    }

    function initializePdfViewer() {
        const containerWidth = previewContainer.clientWidth;
        const containerHeight = Math.max(400, Math.min(800, containerWidth * 1.4)); // Maintain aspect ratio
        pdfViewer.style.height = `${containerHeight}px`;
    }

    // Modal functionality
    function openModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
        
        // Add escape key listener
        document.addEventListener('keydown', handleEscapeKey);
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restore scrolling
        
        // Remove escape key listener
        document.removeEventListener('keydown', handleEscapeKey);
    }

    function handleEscapeKey(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    }

    // Close modal on background click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Make these functions globally available
    window.openModal = openModal;
    window.closeModal = closeModal;

    // Handle form submission
    const form = document.getElementById('previewForm');
    form.addEventListener('submit', function(e) {
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Submitting...
        `;
    });

    // Handle window resize for responsive layout
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (pdfViewer) {
                initializePdfViewer();
            }
        }, 250);
    });

    // Add touch support for mobile devices
    if ('ontouchstart' in window) {
        modal.addEventListener('touchstart', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/user/partials/preview_research.blade.php ENDPATH**/ ?>