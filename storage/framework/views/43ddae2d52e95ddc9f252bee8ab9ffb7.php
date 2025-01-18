

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-semibold mb-4">
            Assessments for Document <?php echo e($serial_number); ?>

        </h1>
        
        <?php if(isset($assessments) && $assessments->isNotEmpty()): ?>
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="text-left bg-gray-100">
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Reviewer</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Thematic Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Title Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Objectives Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Methodology Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Output Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Correction Type</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">General Comments</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <?php echo e($assessment->reviewer ? $assessment->reviewer->first_name . ' ' . $assessment->reviewer->last_name : 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->thematic_score); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->title_score); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->objectives_score); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->methodology_score); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->output_score); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <?php if($assessment->correction_type): ?>
                                    <span class="px-2 py-1 text-xs font-semibold <?php echo e($assessment->correction_type == 'minor' ? 'bg-yellow-100 text-yellow-800' : ($assessment->correction_type == 'major' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')); ?>">
                                        <?php echo e(ucfirst($assessment->correction_type)); ?>

                                    </span>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->general_comments ?: 'No comments'); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->total_score ?: 'No score'); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <a href="<?php echo e(route('assessments.download-pdf', $assessment->abstract_submission_id)); ?>" 
                                    class="relative p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 group" 
                                    title="Download Assessment Form">
                                    <!-- Download Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 4v12m0 0l-4-4m4 4l4-4m0 8H8m8 0h4"/>
                                    </svg>
                                    <!-- Tooltip -->
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                         Download assessment
                                    </span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <!-- Pagination Container -->
            <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <?php if($assessments->onFirstPage()): ?>
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed rounded-md">
                                    Previous
                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($assessments->previousPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Previous
                                </a>
                            <?php endif; ?>

                            <?php if($assessments->hasMorePages()): ?>
                                <a href="<?php echo e($assessments->nextPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Next
                                </a>
                            <?php else: ?>
                                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed rounded-md">
                                    Next
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Desktop View -->
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium"><?php echo e($assessments->firstItem()); ?></span>
                                    to
                                    <span class="font-medium"><?php echo e($assessments->lastItem()); ?></span>
                                    of
                                    <span class="font-medium"><?php echo e($assessments->total()); ?></span>
                                    results
                                </p>
                            </div>

                            <!-- Page Numbers -->
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    
                                    <?php if($assessments->onFirstPage()): ?>
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    <?php else: ?>
                                        <a href="<?php echo e($assessments->previousPageUrl()); ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php $__currentLoopData = $assessments->getUrlRange(1, $assessments->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($page == $assessments->currentPage()): ?>
                                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                                                <?php echo e($page); ?>

                                            </span>
                                        <?php else: ?>
                                            <a href="<?php echo e($url); ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                <?php echo e($page); ?>

                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    
                                    <?php if($assessments->hasMorePages()): ?>
                                        <a href="<?php echo e($assessments->nextPageUrl()); ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    <?php endif; ?>
                                </nav>
                            </div>
                        </div>
                    </div>
        <?php elseif(isset($proposalAssessments) && $proposalAssessments->isNotEmpty()): ?>
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="text-left bg-gray-100">
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Reviewer</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Thematic Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Title Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Objectives Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Methodology Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Output Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Correction Type</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">General Comments</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $proposalAssessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <?php echo e($assessment->reviewer ? $assessment->reviewer->first_name . ' ' . $assessment->reviewer->last_name : 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->thematic_score); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->title_score); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->objectives_score); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->methodology_score); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->output_score); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <?php if($assessment->correction_type): ?>
                                    <span class="px-2 py-1 text-xs font-semibold <?php echo e($assessment->correction_type == 'minor' ? 'bg-yellow-100 text-yellow-800' : ($assessment->correction_type == 'major' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')); ?>">
                                        <?php echo e(ucfirst($assessment->correction_type)); ?>

                                    </span>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->general_comments ?: 'No comments'); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($assessment->total_score ?: 'No score'); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <a href="<?php echo e(route('assessments.proposal.download-pdf', $assessment->abstract_submission_id)); ?>" 
                                        class="relative p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 group" 
                                        title="Download Assessment Form">
                                        <!-- Download Icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M12 4v12m0 0l-4-4m4 4l4-4m0 8H8m8 0h4"/>
                                        </svg>
                                        <!-- Tooltip -->
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                            Download assessment
                                        </span>
                                    </a>
                                </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <!-- Pagination Container -->
            <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <?php if($proposalAssessments->onFirstPage()): ?>
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed rounded-md">
                                    Previous
                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($proposalAssessments->previousPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Previous
                                </a>
                            <?php endif; ?>

                            <?php if($proposalAssessments->hasMorePages()): ?>
                                <a href="<?php echo e($proposalAssessments->nextPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Next
                                </a>
                            <?php else: ?>
                                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed rounded-md">
                                    Next
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Desktop View -->
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium"><?php echo e($proposalAssessments->firstItem()); ?></span>
                                    to
                                    <span class="font-medium"><?php echo e($proposalAssessments->lastItem()); ?></span>
                                    of
                                    <span class="font-medium"><?php echo e($proposalAssessments->total()); ?></span>
                                    results
                                </p>
                            </div>

                            <!-- Page Numbers -->
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    
                                    <?php if($proposalAssessments->onFirstPage()): ?>
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    <?php else: ?>
                                        <a href="<?php echo e($proposalAssessments->previousPageUrl()); ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php $__currentLoopData = $proposalAssessments->getUrlRange(1, $proposalAssessments->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($page == $proposalAssessments->currentPage()): ?>
                                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                                                <?php echo e($page); ?>

                                            </span>
                                        <?php else: ?>
                                            <a href="<?php echo e($url); ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                <?php echo e($page); ?>

                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    
                                    <?php if($proposalAssessments->hasMorePages()): ?>
                                        <a href="<?php echo e($proposalAssessments->nextPageUrl()); ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    <?php endif; ?>
                                </nav>
                            </div>
                        </div>
                    </div>
        <?php else: ?>
            <div class="mt-4 text-gray-500">No assessments found for this document.</div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/admin/partials/research_assessments.blade.php ENDPATH**/ ?>