

<?php $__env->startSection('user-content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Progress Tracker -->
    <div class="max-w-4xl mx-auto mb-8">
        <div class="relative">
            <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
            <div class="absolute top-1/2 left-0 w-3/4 h-1 bg-green-500 -translate-y-1/2 transition-all duration-500"></div>

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
    <div class="max-w-7xl mx-auto">
        <form 
            action="<?php echo e(route('submit.preview_research')); ?>"
            enctype="multipart/form-data"
            method="POST"
            id="previewForm">
            <?php echo csrf_field(); ?>
            <div class="bg-white shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white">Preview Submission</h2>
                    <p class="text-green-100 text-sm mt-2">Review your submission details before proceeding.</p>
                </div>

                <div class="flex flex-col lg:flex-row">
                    <div class="w-full lg:w-1/2 p-6 border border-gray-800">
                        <div class="bg-grey-50 space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Abstract Details</h3>
                                <div class="rounded-lg p-4">
                                    <div class="space-y-4">
                                        <div class="p-8">
                                            <h1 class="text-3xl font-bold text-gray-900 text-center mb-2">
                                                <?php echo e($articleTitle ?? 'Untitled'); ?>

                                            </h1>
                                            <div class="p-8">
                                                <!-- Authors -->
                                                <h1 class="text-1xl font-bold text-gray-900 text-center mb-2">
                                                    <?php if(isset($authorData) && is_array($authorData)): ?>
                                                        <?php echo e(implode(', ', array_map(fn($author) => $author['first_name'] . ' ' . ($author['middle_name'] ?? '') . ' ' . $author['surname'] . (isset($author['is_correspondent']) && $author['is_correspondent'] ? '*' : ''), $authorData))); ?>

                                                    <?php endif; ?>
                                                </h1>
                                                
                                                <!-- Universities -->
                                                <h2 class="text-lg font-medium text-gray-700 text-center">
                                                    <?php if(isset($authorData) && is_array($authorData)): ?>
                                                        <?php echo e(implode(', ', array_map(fn($author) => $author['university'], $authorData))); ?>

                                                    <?php endif; ?>
                                                </h2>
                                                
                                                <!-- Departments -->
                                                <h3 class="text-md text-gray-600 text-center">
                                                    <?php if(isset($authorData) && is_array($authorData)): ?>
                                                        <?php echo e(implode(', ', array_map(fn($author) => $author['department'], $authorData))); ?>

                                                    <?php endif; ?>
                                                </h3>
                                            </div>
                                        </div>                                       
                                    </div>
                                    <div>
                                   
                                
                                    <div class="rounded-lg p-2">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Abstract</h3>
                                        <div class="prose max-w-none">
                                            <?php echo e($abstract); ?>

                                        </div>
                                    </div>
                                        <div class="pt-4">
                                            <h4 class="text-sm font-medium text-gray-500  font-semibold">Title</h4>
                                            <p class="mt-1 text-base text-gray-900"><?php echo e($articleTitle); ?></p>
                                            <input type="hidden" name="article_title" value="<?php echo e($articleTitle); ?>">
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500  font-semibold">Sub-Theme</h4>
                                            <p class="mt-1 text-base text-gray-900"><?php echo e($subTheme); ?></p>
                                            <input type="hidden" name="sub_theme" value="<?php echo e($subTheme); ?>">
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-800 font-semibold">Keywords</h4>
                                            <div class="mt-1 flex flex-wrap gap-2">
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
                                        <div class="mt-4 text-sm text-gray-500">
                                            Word count: <?php echo e(str_word_count($abstract)); ?>

                                        </div>
                                        <input type="hidden" name="abstract" value="<?php echo e($abstract); ?>">
                                    
                                
                                </div>

                            </div>
                        </div>

                            
                    </div>
                </div>

                <div class="w-full lg:w-1/2 p-6 border border-gray-800 flex flex-col h-full">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Document Preview</h3>
                    <div class="bg-gray-50 rounded-lg flex-1">
                        <?php if($documentPath && Storage::disk('public')->exists($documentPath)): ?>
                            <?php if(pathinfo($documentPath, PATHINFO_EXTENSION) === 'pdf'): ?>
                                <embed src="<?php echo e(asset('storage/' . $documentPath)); ?>"
                                    type="application/pdf"
                                    class="w-full h-full rounded-lg"
                                    style="min-height: 800px;">
                            <?php else: ?>
                                <p class="text-gray-500">File is not a valid PDF.</p>
                            <?php endif; ?>
                            <input type="hidden" name="document_path" value="<?php echo e($documentPath); ?>">
                        <?php else: ?>
                            <div class="flex items-center justify-center h-full">
                                <p class="text-gray-500">No document uploaded or file not found</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <a href="<?php echo e(route('user.step2_research')); ?>" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400">
                            Previous
                        </a>
                        <a href="<?php echo e(route('user.downloadAbstractPdf')); ?>"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Download Abstract as PDF
                        </a>
                        <button type="button" onclick="openModal()" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 flex items-center">
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
<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <!-- Modal Content -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Ready for Submission</h3>
        </div>

        <!-- Important Notes -->
        <div class="space-y-4 border-t border-gray-200 pt-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-gray-800">Review Process</h4>
                    <p class="text-sm text-gray-600">Your abstract will be reviewed. You will be notified of the decision via email.</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-gray-800">Important Notice</h4>
                        <p class="text-sm text-gray-600">Once submitted, you cannot make changes to your abstract. Please ensure all details are correct.</p>
                </div>
            </div>
        </div>

        <!-- Modal Buttons -->
        <div class="mt-4 flex justify-end space-x-2">
            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                Cancel
            </button>
            <button type="submit" form="previewForm" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Confirm
            </button>
        </div>
    </div>
</div>
<script>
    function openModal() {
        document.getElementById('confirmationModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\email-verification-app\resources\views\user\partials\preview_research.blade.php ENDPATH**/ ?>