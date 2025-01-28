<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">| Dashboard</h1>
    <p class="mt-2 text-sm text-gray-600">Review, rate, and provide feedback on submitted documents. Approve, request revisions, or reject submissions as necessary.</p>
</div>

<!-- Stats & Overview Section -->
<!-- Dashboard Content -->                
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Stats Card 1 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9m-9 0H7a2 2 0 01-2-2V6a2 2 0 012-2h8l5 5v9a2 2 0 01-2 2h-6z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 10h-4m0 4h4m-8 4h8"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Articles</p>
                                <p class="text-2xl font-semibold text-gray-700"><?php echo e($abstractCount); ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- Stats Card 2 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7 2h10a2 2 0 012 2v16a2 2 0 01-2 2H7a2 2 0 01-2-2V4a2 2 0 012-2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v2m0 4h.01"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Proposals</p>
                                    <p class="text-2xl font-semibold text-gray-700"><?php echo e($proposalCount); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card 3 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-7a9 9 0 11-6.219-8.785"/>
                            </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Pending</p>
                                <p class="text-2xl font-semibold text-gray-700"><?php echo e($newProposalCount + $newAbstractCount); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card 4 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4h9m-2 2l2-2-2-2M7 9l4 4-3 1-1-3 3-2zM3 16v3h3l9-9-3-3-9 9z"/>
                            </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Revisions</p>
                                <p class="text-2xl font-semibold text-gray-700">0</p>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Document Management Section -->
<div x-data="{ activeTab: 'articles' }">
    <div class="flex justify-between items-center p-4">
        <h2 class="text-2xl font-semibold text-gray-800 tracking-tight p-4">Recents</h2>
        <div class="flex items-center gap-4">
            <div class="relative">
                <form x-data="{ searchQuery: '<?php echo e($searchQuery); ?>' }" 
                    x-on:submit.prevent="window.location.href = '?search=' + searchQuery">
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Search documents..."
                        class="w-64 px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    <button type="submit" class="absolute right-3 top-2.5">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>   
        </div>
    </div>

    <!-- Tabbed Navigation Menu -->
    <div class="bg-white border-b border-gray-200">
        <div class="flex">
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'articles', 'border-transparent': activeTab !== 'articles' }"
                @click="activeTab = 'articles'">
                Articles
                <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs"><?php echo e($newAbstractCount); ?></span>
            </button>
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'proposals', 'border-transparent': activeTab !== 'proposals' }"
                @click="activeTab = 'proposals'">
                Research Proposals
                <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs"><?php echo e($newProposalCount); ?></span>
            </button>
        </div>
    </div>

    <!-- Tab Content - Abstracts, Articles, and Proposals -->
    <div class="bg-white shadow-sm">
        <!-- Articles Tab -->
        <div x-show="activeTab === 'articles'" class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Serial_No</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Sub_Theme</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($submission->serial_number); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($submission->title); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-500"><?php echo e($submission->sub_theme); ?></td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 text-xs font-medium <?php echo e(($submission->reviewer_status === null || $submission->reviewer_status === '') ? 'text-red-800 bg-red-100' : 'text-yellow-800 bg-yellow-100'); ?> rounded-full">
                                <?php echo e($submission->reviewer_status === null || $submission->reviewer_status === '' ? 'Pending' : $submission->reviewer_status); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <button 
                                aria-label="Preview abstract"
                                class="px-2 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full"
                                
                                @click="$store.modal.open({ serial_number: '<?php echo e($submission->serial_number); ?>' })"
                            >
                                Preview
                            </button>
                            <a href="<?php echo e(route('research.reviewerAbstract.download', $submission->serial_number)); ?>" class="px-2 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">
                                Download
                            </a>
                        </td>
                        
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">
                            <?php echo e($searchQuery 
                                ? "No documents found matching '" . htmlspecialchars($searchQuery) . "'" 
                                : "No documents assigned to review yet."); ?>

                        </td>
                    </tr>
            <?php endif; ?>
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
            <div 
                x-data="{ zoomLevel: 100 }"
                x-show="$store.modal.isOpen"
                @keydown.escape.window="$store.modal.close()"
                class="fixed inset-0 z-50 overflow-hidden bg-black bg-opacity-50"
                style="display: none;"
            >
                <!-- Main container with padding -->
                <div class="min-h-screen w-full p-4 md:p-6">
                    <!-- Modal container with max height -->
                    <div 
                        class="mx-auto max-w-4xl bg-white shadow-xl flex flex-col"
                        @click.away="$store.modal.close()"
                        style="max-height: calc(100vh - 2rem);"
                    >
                        <!-- Header - Fixed -->
                        <div class="flex-none bg-white px-6 py-4 border-b border-gray-200 rounded-t-lg">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">Preview</h2>
                                <button 
                                    @click="$store.modal.close()" 
                                    class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg"
                                    title="Close"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Content - Scrollable -->
                        <div class="flex-1 overflow-y-auto">
                            <div class="p-6 md:p-8">
                                <div class="max-w-3xl mx-auto space-y-6">
                                    <template x-if="$store.modal.abstract">
                                        <div class="space-y-6">
                                            <!-- Title -->
                                            <h1 
                                                x-text="$store.modal.abstract.title"
                                                class="text-2xl font-bold text-center text-gray-900 mb-4"
                                            ></h1>

                                            <!-- Abstract -->
                                            <div class="space-y-4">
                                                <h2 class="text-lg font-bold text-gray-900">Abstract</h2>
                                                <p 
                                                    x-text="$store.modal.abstract.content"
                                                    class="text-gray-700 leading-relaxed text-justify"
                                                ></p>
                                            </div>

                                            <!-- Keywords -->
                                            <div class="space-y-2">
                                                <h3 class="font-bold text-gray-900">Keywords</h3>
                                                <p x-text="$store.modal.abstract.keywords || 'Not available'" class="text-gray-700"></p>
                                            </div>

                                            <!-- Sub-Theme -->
                                            <div class="space-y-2">
                                                <h3 class="font-bold text-gray-900">Sub-Theme</h3>
                                                <p x-text="$store.modal.abstract.sub_theme || 'Not available'" class="text-gray-700"></p>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Loading State -->
                                    <template x-if="!$store.modal.abstract">
                                        <div class="flex justify-center items-center py-12">
                                            <p class="text-gray-500">Loading...</p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Footer - Fixed -->
                        <div class="flex-none bg-gray-50 px-6 py-4 border-t border-gray-200 rounded-b-lg">
                            <div class="flex justify-end space-x-2">
                                <a x-show="$store.modal.abstract" 
                                x-bind:href="`<?php echo e(url('reviewer/abstract/accept')); ?>/${$store.modal.abstract.serial_number}`"
                                class="px-2 py-1 text-xs font-medium text-white bg-green-600 hover:bg-blue-700 rounded-full">
                                    Accept
                                </a>
                                    <a x-show="$store.modal.abstract"
                                    x-bind:href="`<?php echo e(url('reviewer/abstract/reject')); ?>/${$store.modal.abstract.serial_number}`"
                                    class="px-2 py-1 text-xs font-medium text-white bg-red-600 hover:bg-blue-700 rounded-full">
                                    Reject</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Research Proposals Tab (Similar Layout as Abstracts) -->
        <div x-show="activeTab === 'proposals'" class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Serial_No</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Sub_Theme</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>        
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $researchSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researchSubmission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($researchSubmission->serial_number); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($researchSubmission->article_title); ?></td>
                        <td class="px-4 py-3 text-sm text-gray-500"><?php echo e($researchSubmission->sub_theme); ?></td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 text-xs font-medium <?php echo e(($researchSubmission->reviewer_status === null || $researchSubmission->reviewer_status === '') ? 'text-red-800 bg-red-100' : 'text-yellow-800 bg-yellow-100'); ?> rounded-full">
                                <?php echo e($researchSubmission->reviewer_status === null || $researchSubmission->reviewer_status === '' ? 'Pending' : $researchSubmission->reviewer_status); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <button 
                                aria-label="Preview abstract"
                                class="px-2 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full"
                                @click="$store.proposalModal.open({ serial_number: '<?php echo e($researchSubmission->serial_number); ?>' })"
                            >
                                Preview
                            </button>
                            <a href="<?php echo e(route('proposal.reviewerAbstract.download', $researchSubmission->serial_number)); ?>" class="px-2 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">
                                Download
                            </a>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center">
                                <?php echo e($searchQuery 
                                    ? "No documents found matching '" . htmlspecialchars($searchQuery) . "'" 
                                    : "No documents assigned to review yet."); ?>

                            </td>
                        </tr>
                        <?php endif; ?>
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
            <div 
                x-data="{ zoomLevel: 100 }"
                x-show="$store.proposalModal.isOpen"
                @keydown.escape.window="$store.proposalModal.close()"
                class="fixed inset-0 z-50 overflow-hidden bg-black bg-opacity-50"
                style="display: none;"
            >
                <!-- Main container with padding -->
                <div class="min-h-screen w-full p-4 md:p-6">
                    <!-- Modal container with max height -->
                    <div 
                        class="mx-auto max-w-4xl bg-white shadow-xl flex flex-col"
                        @click.away="$store.proposalModal.close()"
                        style="max-height: calc(100vh - 2rem);"
                    >
                        <!-- Header - Fixed -->
                        <div class="flex-none bg-white px-6 py-4 border-b border-gray-200 rounded-t-lg">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">Preview</h2>
                                <button 
                                    @click="$store.proposalModal.close()" 
                                    class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg"
                                    title="Close"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Content - Scrollable -->
                        <div class="flex-1 overflow-y-auto">
                            <div class="p-6 md:p-8">
                                <div class="max-w-3xl mx-auto space-y-6">
                                    <template x-if="$store.proposalModal.proposal">
                                        <div class="space-y-6">
                                            <!-- Title -->
                                            <h1 
                                                x-text="$store.proposalModal.proposal.title"
                                                class="text-2xl font-bold text-center text-gray-900 mb-8"
                                            ></h1>

                                            <!-- Abstract -->
                                            <div class="space-y-4">
                                                <h2 class="text-lg font-bold text-gray-900">Abstract</h2>
                                                <p 
                                                    x-text="$store.proposalModal.proposal.content"
                                                    class="text-gray-700 leading-relaxed text-justify"
                                                ></p>
                                            </div>

                                            <!-- Keywords -->
                                            <div class="space-y-2">
                                                <h3 class="font-bold text-gray-900">Keywords</h3>
                                                <p x-text="$store.proposalModal.proposal.keywords || 'Not available'" class="text-gray-700"></p>
                                            </div>

                                            <!-- Sub-Theme -->
                                            <div class="space-y-2">
                                                <h3 class="font-bold text-gray-900">Sub-Theme</h3>
                                                <p x-text="$store.proposalModal.proposal.sub_theme || 'Not available'" class="text-gray-700"></p>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Loading State -->
                                    <template x-if="!$store.proposalModal.proposal">
                                        <div class="flex justify-center items-center py-12">
                                            <p class="text-gray-500">Loading...</p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Footer - Fixed -->
                        <div class="flex-none bg-gray-50 px-6 py-4 border-t border-gray-200 rounded-b-lg">
                            <div class="flex justify-end space-x-2">
                                <a x-show="$store.proposalModal.proposal"
                                x-bind:href="`<?php echo e(url('reviewer/proposal/accept')); ?>/${$store.proposalModal.proposal.serial_number}`"
                                class="px-2 py-1 text-xs font-medium text-white bg-green-600 hover:bg-blue-700 rounded-full">
                                    Accept
                                </a>
                                <a x-show="$store.proposalModal.proposal"
                                    x-bind:href="`<?php echo e(url('reviewer/proposal/reject')); ?>/${$store.proposalModal.proposal.serial_number}`"
                                    class="px-2 py-1 text-xs font-medium text-white bg-red-600 hover:bg-blue-700 rounded-full">Reject</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('modal', {
        isOpen: false,
        abstract: null,
        open(params) {
            this.isOpen = true;
            this.loadAbstract(params.serial_number);
        },
        close() {
            this.isOpen = false;
            this.abstract = null;
        },
        async loadAbstract(serial_number) {
            try {
                const response = await fetch(`/reviewer/abstracts/${serial_number}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                this.abstract = {
                    serial_number: serial_number,
                    title: data.title,
                    content: data.abstract,
                    keywords: data.keywords,
                    sub_theme: data.sub_theme,
                    authors: data.authors
                };
            } catch (error) {
                console.error('Error fetching abstract:', error);
                this.abstract = {
                    title: 'Error Loading Abstract',
                    content: 'There was a problem loading this abstract. Please try again or contact support.',
                    keywords: '',
                    sub_theme: '',
                    authors: []
                };
            }
        },
    });
});
</script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('proposalModal', {
        isOpen: false,
        proposal: null,
        open(params) {
            this.isOpen = true;
            this.loadProposal(params.serial_number);
        },
        close() {
            this.isOpen = false;
            this.proposal = null;
        },
        async loadProposal(serial_number) {
            try {
                const response = await fetch(`/reviewer/proposals/${serial_number}`);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                this.proposal = {
                    serial_number: serial_number,
                    title: data.title,
                    content: data.abstract,
                    keywords: data.keywords,
                    sub_theme: data.sub_theme,
                    authors: data.authors || []
                };
            } catch (error) {
                console.error('Error fetching proposal:', error);
                this.proposal = {
                    title: 'Error',
                    content: 'Failed to load abstract. Please try again.',
                    keywords: '',
                    sub_theme: '',
                    authors: []
                };
            }
        },
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/reviewer/partials/dashboard.blade.php ENDPATH**/ ?>