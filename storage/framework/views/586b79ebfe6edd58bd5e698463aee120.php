

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 p-8">
    <!-- Header with gradient background -->
    <div class="relative mb-8 bg-gradient-to-r from-gray-100 to-grey-200 p-6 shadow-lg">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <h1 class="text-3xl font-bold text-black">Reports</h1>
            <div class="flex flex-wrap gap-3">
                <a href="<?php echo e(route('abstract.downloadAll')); ?>" class="px-4 py-2 bg-white/10 backdrop-blur-md text-black rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Abstracts PDF
                </a>
                <a href="<?php echo e(route('abstracts.download.word')); ?>" class="px-4 py-2 bg-white/10 backdrop-blur-md text-black rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Abstracts Word
                </a>
                <a href="<?php echo e(route('proposal.downloadAll')); ?>" class="px-4 py-2 bg-white/10 backdrop-blur-md text-black rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Proposals PDF
                </a>
                <a href="<?php echo e(route('proposal.downloadAllWord')); ?>" class="px-4 py-2 bg-white/10 backdrop-blur-md text-black rounded-lg hover:bg-white/20 transition duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Proposals Word
                </a>
            </div>
        </div>
    </div>

    <!-- Analytics Cards Grid 
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Total Submissions</h3>
                <span class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </span>
            </div>
            <p class="text-3xl font-bold text-gray-900">2,451</p>
            <p class="text-sm text-gray-500 mt-2">↑ 12% from last month</p>
        </div>
    </div> 
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition duration-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Submission Trends</h3>
            <canvas id="submissionTrendsChart" class="w-full h-64"></canvas>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition duration-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Approval Rates</h3>
            <canvas id="approvalRatesChart" class="w-full h-64"></canvas>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition duration-200">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Average Marks</h3>
            <canvas id="averageMarksChart" class="w-full h-64"></canvas>
        </div>
    </div>-->

    <div x-data="{ activeTab: 'abstracts' }">
        <!-- Tabbed Menu -->
        <div class="bg-white border-b border-gray-200">
            <div class="flex">
                <button 
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150"
                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'abstracts', 'border-transparent': activeTab !== 'abstracts' }"
                    @click="activeTab = 'abstracts'">
                    Abstracts
                </button>
                <button 
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150"
                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'proposals', 'border-transparent': activeTab !== 'proposals' }"
                    @click="activeTab = 'proposals'">
                    Research Proposals
                </button>
            </div>
        </div>
        <div x-show="activeTab === 'abstracts'">
            <div class="mt-6 px-6 py-4 bg-white rounded-lg shadow-md border border-gray-200">
                <?php if(session('success')): ?>
                    <div class="bg-green-100 border border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                        <p class="font-medium"><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800">Document Reports</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Title</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Submitted By</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Uploaded On</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Reviewed By</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Score</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Final Status</th>                        
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <div class="font-medium"><?php echo e($submission->title); ?></div>
                                            <div class="text-xs text-gray-500"><?php echo e($submission->serial_number); ?></div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <div class="font-medium"><?php echo e($submission->user->first_name); ?> <?php echo e($submission->user->last_name); ?></div>
                                            <div class="text-xs text-gray-500"><?php echo e($submission->user->reg_no); ?></div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500"><?php echo e(\Carbon\Carbon::parse($submission->created_at)->format('d M Y')); ?></td>
                                        <td class="px-6 py-4">
                                            <?php if($submission->reviewer): ?>
                                                <div class="font-medium"><?php echo e($submission->reviewer->first_name); ?> <?php echo e($submission->reviewer->last_name); ?></div>
                                                <div class="text-xs text-gray-500"><?php echo e($submission->reviewer->reg_no); ?></div>
                                            <?php else: ?>
                                                <div class="font-medium text-gray-500">No Reviewer Assigned</div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-medium text-gray-700"><?php echo e($submission->score ?? 'No Assessed'); ?></span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-medium 
                                                <?php if($submission->approved == true): ?>
                                                    text-green-600 
                                                <?php else: ?>
                                                    text-red-600  
                                                <?php endif; ?>
                                            ">
                                                <?php echo e($submission->approved == true ? 'Approved' : 'Declined'); ?>

                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- View Assessments Button -->
                                                <a href="<?php echo e(route('admin.showAssessments', ['serial_number' => $submission->serial_number ])); ?>" 
                                                class="relative p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 group">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    <!-- Tooltip -->
                                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                                        View assessments
                                                    </span>
                                                </a>

                                                <!-- Delete Button -->
                                                <button onclick="deleteAssessment('<?php echo e($submission->serial_number); ?>')"
                                                        class="relative p-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-200 group">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    <!-- Tooltip -->
                                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                                        Delete document
                                                    </span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <!-- Pagination Container -->
                    <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <?php if($submissions->onFirstPage()): ?>
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed rounded-md">
                                    Previous
                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($submissions->previousPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Previous
                                </a>
                            <?php endif; ?>

                            <?php if($submissions->hasMorePages()): ?>
                                <a href="<?php echo e($submissions->nextPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
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
                                    <span class="font-medium"><?php echo e($submissions->firstItem()); ?></span>
                                    to
                                    <span class="font-medium"><?php echo e($submissions->lastItem()); ?></span>
                                    of
                                    <span class="font-medium"><?php echo e($submissions->total()); ?></span>
                                    results
                                </p>
                            </div>

                            <!-- Page Numbers -->
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    
                                    <?php if($submissions->onFirstPage()): ?>
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    <?php else: ?>
                                        <a href="<?php echo e($submissions->previousPageUrl()); ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php $__currentLoopData = $submissions->getUrlRange(1, $submissions->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($page == $submissions->currentPage()): ?>
                                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                                                <?php echo e($page); ?>

                                            </span>
                                        <?php else: ?>
                                            <a href="<?php echo e($url); ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                <?php echo e($page); ?>

                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    
                                    <?php if($submissions->hasMorePages()): ?>
                                        <a href="<?php echo e($submissions->nextPageUrl()); ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
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
                    </div>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'proposals'">
            <div class="mt-6 px-6 py-4 bg-white rounded-lg shadow-md border border-gray-200">
                <?php if(session('success')): ?>
                    <div class="bg-green-100 border border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                        <p class="font-medium"><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-xl font-semibold text-gray-800">Document Reports</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Title</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Submitted By</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Uploaded On</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Reviewer By</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Score</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Final status</th>                        
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                            <?php $__currentLoopData = $researchSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researchSubmission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <div class="font-medium"><?php echo e($researchSubmission->article_title); ?></div>
                                            <div class="text-xs text-gray-500"><?php echo e($researchSubmission->serial_number); ?></div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <div class="font-medium"><?php echo e($researchSubmission->user->first_name); ?> <?php echo e($researchSubmission->user->last_name); ?></div>
                                            <div class="text-xs text-gray-500"><?php echo e($researchSubmission->user->reg_no); ?></div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500"><?php echo e(\Carbon\Carbon::parse($researchSubmission->created_at)->format('d M Y')); ?></td>
                                        <td class="px-6 py-4">
                                            <?php if($researchSubmission->reviewer): ?>
                                                <div class="font-medium"><?php echo e($researchSubmission->reviewer->first_name); ?> <?php echo e($researchSubmission->reviewer->last_name); ?></div>
                                                <div class="text-xs text-gray-500"><?php echo e($researchSubmission->reviewer->reg_no); ?></div>
                                            <?php else: ?>
                                                <div class="font-medium text-gray-500">No Reviewer Assigned</div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-medium text-gray-700"><?php echo e($researchSubmission->score ?? 'No Assessed'); ?></span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-medium 
                                                <?php if($researchSubmission->approved == true): ?>
                                                    text-green-600 
                                                <?php else: ?>
                                                    text-red-600  
                                                <?php endif; ?>
                                            ">
                                                <?php echo e($researchSubmission->approved == true ? 'Approved' : 'Declined'); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- View Assessments Button -->
                                                <a href="<?php echo e(route('admin.proposal.showAssessments', ['serial_number' => $researchSubmission->serial_number ])); ?>" 
                                                class="relative p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 group">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    <!-- Tooltip -->
                                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                                        View assessments
                                                    </span>
                                                </a>

                                                <!-- Delete Button -->
                                                <button onclick="deleteAssessment('<?php echo e($researchSubmission->serial_number); ?>')"
                                                        class="relative p-2 text-red-600 hover:bg-red-50 rounded-lg transition duration-200 group">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    <!-- Tooltip -->
                                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                                        Delete document
                                                    </span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <!-- Pagination Container -->
                    <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <?php if($researchSubmissions->onFirstPage()): ?>
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed rounded-md">
                                    Previous
                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($researchSubmissions->previousPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Previous
                                </a>
                            <?php endif; ?>

                            <?php if($researchSubmissions->hasMorePages()): ?>
                                <a href="<?php echo e($researchSubmissions->nextPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
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
                                    <span class="font-medium"><?php echo e($researchSubmissions->firstItem()); ?></span>
                                    to
                                    <span class="font-medium"><?php echo e($researchSubmissions->lastItem()); ?></span>
                                    of
                                    <span class="font-medium"><?php echo e($researchSubmissions->total()); ?></span>
                                    results
                                </p>
                            </div>

                            <!-- Page Numbers -->
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    
                                    <?php if($researchSubmissions->onFirstPage()): ?>
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    <?php else: ?>
                                        <a href="<?php echo e($researchSubmissions->previousPageUrl()); ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    
                                    <?php $__currentLoopData = $researchSubmissions->getUrlRange(1, $researchSubmissions->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($page == $researchSubmissions->currentPage()): ?>
                                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                                                <?php echo e($page); ?>

                                            </span>
                                        <?php else: ?>
                                            <a href="<?php echo e($url); ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                <?php echo e($page); ?>

                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    
                                    <?php if($researchSubmissions->hasMorePages()): ?>
                                        <a href="<?php echo e($researchSubmissions->nextPageUrl()); ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Function to show notification
    function showNotification(type, message) {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.notification-toast');
        existingNotifications.forEach(notification => {
            notification.remove();
        });

        // Create notification container
        const notification = document.createElement('div');
        notification.className = `notification-toast fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out opacity-0 z-50 flex items-center space-x-2 min-w-[300px]`;
        
        // Define notification types and their styles
        const notificationTypes = {
            error: {
                background: 'bg-red-500',
                icon: `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>`
            },
            warning: {
                background: 'bg-yellow-500',
                icon: `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>`
            },
            success: {
                background: 'bg-green-500',
                icon: `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>`
            },
            info: {
                background: 'bg-blue-500',
                icon: `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>`
            }
        };

        // Get notification style based on type
        const notificationStyle = notificationTypes[type] || notificationTypes.info;
        notification.classList.add(notificationStyle.background);

        // Create notification content
        const iconContainer = document.createElement('div');
        iconContainer.className = 'flex-shrink-0';
        iconContainer.innerHTML = notificationStyle.icon;

        const messageContainer = document.createElement('div');
        messageContainer.className = 'flex-grow text-white text-sm font-medium';
        messageContainer.textContent = message;

        const closeButton = document.createElement('button');
        closeButton.className = 'flex-shrink-0 ml-4 text-white hover:text-gray-200 focus:outline-none';
        closeButton.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>`;
        
        // Add content to notification
        notification.appendChild(iconContainer);
        notification.appendChild(messageContainer);
        notification.appendChild(closeButton);
        
        // Add notification to DOM
        document.body.appendChild(notification);

        // Show notification with animation
        requestAnimationFrame(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        });

        // Close button functionality
        closeButton.addEventListener('click', () => {
            hideNotification(notification);
        });

        // Auto-hide after delay
        const timeout = setTimeout(() => {
            hideNotification(notification);
        }, 5000);

        // Store timeout in notification element
        notification.dataset.timeout = timeout;
    }

    // Function to hide notification with animation
    function hideNotification(notification) {
        // Clear the timeout to prevent duplicate animations
        if (notification.dataset.timeout) {
            clearTimeout(notification.dataset.timeout);
        }

        // Add exit animation
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-10px)';

        // Remove notification after animation
        setTimeout(() => {
            if (notification && notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }
// Handle delete document via AJAX
window.deleteAssessment = function (serialNumber) {
    fetch(`/admin/delete/assessment/${serialNumber}`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
        }
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error("Network response was not OK");
        })
        .then(data => {
            if (data.message) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showNotification(data.error || "Failed to delete document", 'error');
            }
        })
        .catch(error => {
            showNotification(error.message || "An error occurred. Please try again later.", 'error');
        });
}
</script>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/admin/partials/reports.blade.php ENDPATH**/ ?>