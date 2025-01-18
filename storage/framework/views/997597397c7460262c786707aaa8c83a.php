<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">| Dashboard</h1>
        <p class="mt-2 text-sm text-gray-600">Welcome back to your admin dashboard</p>
</div>
                <!-- Dashboard Content -->                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Stats Card 1 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Articles</p>
                                <p class="text-2xl font-semibold text-gray-700"><?php echo e($totalAbstracts); ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- Stats Card 2 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Proposals</p>
                                    <p class="text-2xl font-semibold text-gray-700"><?php echo e($totalProposals); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card 3 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Users</p>
                                <p class="text-2xl font-semibold text-gray-700"><?php echo e($totalUsers); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card 4 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Reviewers</p>
                                <p class="text-2xl font-semibold text-gray-700"><?php echo e($totalReviewers); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Wrap everything in a single Alpine.js component -->
    <div x-data="{ activeTab: 'abstracts' }">
        <div class="border-b border-gray-200 shadow-sm bg-white">
            <h2 class="text-2xl font-semibold text-gray-800 tracking-tight p-4">Recents</h2>
        </div>

        <!-- Tabbed Menu - Removed extra padding -->
        <div class="bg-white border-b border-gray-200">
            <div class="flex">
                <button 
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150"
                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'abstracts', 'border-transparent': activeTab !== 'abstracts' }"
                    @click="activeTab = 'abstracts'">
                    Articles
                </button>
                <button 
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150"
                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'proposals', 'border-transparent': activeTab !== 'proposals' }"
                    @click="activeTab = 'proposals'">
                    Research Proposals
                </button>
            </div>
        </div>

        <!-- Tab Content - Adjusted spacing -->
        <div class="bg-white shadow-sm h-96">
            <!-- Articles Tab -->
            <div x-show="activeTab === 'abstracts'" class="overflow-x-auto h-96">
                <table class="min-w-full table-auto">                
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Serial Number</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Uploaded By</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Uploaded On</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <span class="font-semibold"><?php echo e($submission->title); ?></span><br>
                                <span><?php echo e($submission->serial_number); ?></span>
                            </td>
                                <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($submission->user_reg_no); ?></td>
                                <td class="px-4 py-3 text-sm text-gray-500"><?php echo e(\Carbon\Carbon::parse($submission->created_at)->format('d M Y')); ?></td>
                                <td class="px-4 py-3 text-center">
                                    <?php
                                        $statusStyles = [
                                            'submitted' => [
                                                'text' => 'text-yellow-800',
                                                'bg' => 'bg-yellow-100'
                                            ],
                                            'under_review' => [
                                                'text' => 'text-blue-800',
                                                'bg' => 'bg-blue-100'
                                            ],
                                            'rejected' => [
                                                'text' => 'text-red-800',
                                                'bg' => 'bg-red-100'
                                            ],
                                            'revision_required' => [
                                                'text' => 'text-orange-800',
                                                'bg' => 'bg-orange-100'
                                            ],
                                            'accepted' => [
                                                'text' => 'text-green-800',
                                                'bg' => 'bg-green-100'
                                            ],
                                        ];

                                        $currentStatus = match($submission->final_status) {
                                            'submitted' => 'Not Accepted',
                                            'under_review' => 'Under Review',
                                            'rejected' => 'Rejected',
                                            'revision_required' => 'Revision Required',
                                            'accepted' => 'Accepted',
                                            default => 'Unknown'
                                        };

                                        $style = $statusStyles[$submission->final_status] ?? [
                                            'text' => 'text-gray-800',
                                            'bg' => 'bg-gray-100'
                                        ];
                                    ?>
                                    <span class="px-3 py-1 text-xs font-medium <?php echo e($style['text']); ?> <?php echo e($style['bg']); ?> rounded-full">
                                        <?php echo e($currentStatus); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div x-data="{ isOpen: false }" class="flex justify-center space-x-1.5">
                                        <form action="<?php echo e(route('accept.abstract')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="serial_number" value="<?php echo e($submission->serial_number); ?>">
                                            <button type="submit" 
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Accept
                                            </button>
                                        </form>

                                        <form x-data="{ isRejectModalOpen: false }" action="<?php echo e(route('reject.abstract')); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="serial_number" value="<?php echo e($submission->serial_number); ?>">
                                            <button type="button" 
                                                @click="isRejectModalOpen = true"
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Reject
                                            </button>

                                            <!-- Rejection Modal Backdrop -->
                                            <div x-show="isRejectModalOpen"
                                                x-cloak 
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0"
                                                class="fixed inset-0 bg-black bg-opacity-50 z-40">
                                            </div>

                                            <!-- Rejection Modal Container -->
                                            <div x-show="isRejectModalOpen"
                                                x-cloak
                                                x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-4"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 translate-y-4"
                                                class="fixed inset-0 z-50 overflow-y-auto"
                                                @click.away="isRejectModalOpen = false">
                                                    
                                                <div class="min-h-screen px-4 text-center">
                                                    <!-- Modal Panel -->
                                                    <div class="inline-block w-full max-w-md p-6 my-8 text-left align-middle bg-white rounded-lg shadow-xl transform transition-all">
                                                        <!-- Header -->
                                                        <div class="flex justify-between items-center pb-3 border-b">
                                                            <h3 class="text-lg font-medium text-gray-900">Reject Abstract</h3>
                                                            <button @click="isRejectModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <!-- Content -->
                                                        <div class="mt-4">
                                                            <label for="rejection_comment" class="block text-sm font-medium text-gray-700 mb-2">
                                                                Please provide a reason for rejection
                                                            </label>
                                                            <textarea
                                                                name="rejection_comment"
                                                                id="rejection_comment"
                                                                rows="4"
                                                                required
                                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
                                                                placeholder="Enter your comments here..."
                                                            ></textarea>
                                                        </div>

                                                        <!-- Footer -->
                                                        <div class="mt-6 flex justify-end space-x-3">
                                                            <button
                                                                type="button"
                                                                @click="isRejectModalOpen = false"
                                                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                                                                Cancel
                                                            </button>
                                                            <button
                                                                type="submit"
                                                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md transition-colors">
                                                                Confirm Rejection
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <button @click="isOpen = true" 
                                            class="inline-flex items-center space-x-1 px-3 py-1 text-xs text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-100 transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Preview Abstract</span>
                                        </button>

                                        <!-- Modal Backdrop -->
                                        <div x-show="isOpen"
                                            x-cloak 
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                            @click="isOpen = false">
                                        </div>

                                        <!-- Modal Container -->
                                        <div x-show="isOpen"
                                            x-cloak
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 translate-y-4"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 translate-y-4"
                                            class="fixed inset-0 z-50 overflow-y-auto"
                                            @click.away="isOpen = false">
                                                
                                            <div class="min-h-screen px-4 text-center">
                                                <!-- Modal Panel -->
                                                <div class="inline-block w-full max-w-4xl p-6 my-8 text-left align-middle bg-white rounded-lg shadow-xl transform transition-all">
                                                    <!-- Header -->
                                                    <div class="flex justify-between items-center pb-3 border-b">
                                                        <h3 class="text-lg font-medium text-gray-900">Research Abstract Preview</h3>
                                                        <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <!-- Content -->
                                                    <div class="mt-4 max-h-[70vh] overflow-y-auto">
                                                        <!-- Title -->
                                                        <h1 class="text-2xl font-serif text-center font-bold mb-6">
                                                            <?php echo e($submission->title); ?>

                                                        </h1>

                                                        <!-- Authors -->
                                                        <div class="text-center mb-8">
                                                            <?php
                                                                $authors = json_decode($submission->authors, true);
                                                            ?>
                                                            <?php if($authors && is_array($authors)): ?>
                                                                <div class="flex flex-wrap justify-center gap-1 mb-2">
                                                                    <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <span class="font-serif text-sm">
                                                                            <?php echo e($author['first_name']); ?> <?php echo e($author['middle_name'] ?? ''); ?> <?php echo e($author['surname']); ?>

                                                                            <?php if($author['is_correspondent']): ?>
                                                                                <span class="text-black-600">*</span>
                                                                            <?php endif; ?>
                                                                            <?php if(!$loop->last): ?>, <?php endif; ?>
                                                                        </span>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </div>
                                                                <!-- Affiliation -->
                                                                <div class="space-y-1 text-gray-600">
                                                                    <p class="font-serif text-xs"><?php echo e($authors[0]['university']); ?></p>
                                                                    <p class="font-serif text-xs"><?php echo e($authors[0]['department']); ?></p>
                                                                </div>
                                                            <?php else: ?>
                                                                <p class="text-gray-500 italic text-sm">No authors available</p>
                                                            <?php endif; ?>
                                                        </div>

                                                        <!-- Abstract -->
                                                        <div class="space-y-4">
                                                            <h2 class="text-lg font-bold text-gray-900">Abstract</h2>
                                                            <p class="text-sm text-gray-700 leading-relaxed text-justify">
                                                                <?php echo e($submission->abstract); ?>

                                                            </p>
                                                        </div>

                                                        <!-- Keywords -->
                                                        <div class="mt-6">
                                                            <h3 class="text-sm font-bold text-gray-900">Keywords</h3>
                                                            <p class="text-sm text-gray-700">
                                                                <?php echo e(implode(', ', json_decode($submission->keywords))); ?>

                                                            </p>
                                                        </div>

                                                        <!-- Sub-Theme -->
                                                        <div class="mt-4">
                                                            <h3 class="text-sm font-bold text-gray-900">Sub-Theme</h3>
                                                            <p class="text-sm text-gray-700"><?php echo e($submission->sub_theme); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
            <!-- Research Proposals Tab -->
            <div x-show="activeTab === 'proposals'" class="p-4">
            <table class="min-w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Serial Number</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Uploaded By</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Uploaded On</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        <?php $__currentLoopData = $researchSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researchSubmission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <span class="font-semibold"><?php echo e($researchSubmission->article_title); ?></span><br>
                                <span><?php echo e($researchSubmission->serial_number); ?></span>
                            </td>
                                <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($researchSubmission->user_reg_no); ?></td>
                                <td class="px-4 py-3 text-sm text-gray-500"><?php echo e(\Carbon\Carbon::parse($researchSubmission->created_at)->format('d M Y')); ?></td>
                                <td class="px-4 py-3 text-center">
                                    <?php
                                        $statusStyles = [
                                            'submitted' => [
                                                'text' => 'text-yellow-800',
                                                'bg' => 'bg-yellow-100'
                                            ],
                                            'under_review' => [
                                                'text' => 'text-blue-800',
                                                'bg' => 'bg-blue-100'
                                            ],
                                            'rejected' => [
                                                'text' => 'text-red-800',
                                                'bg' => 'bg-red-100'
                                            ],
                                            'revision_required' => [
                                                'text' => 'text-orange-800',
                                                'bg' => 'bg-orange-100'
                                            ],
                                            'accepted' => [
                                                'text' => 'text-green-800',
                                                'bg' => 'bg-green-100'
                                            ],
                                        ];

                                        $currentStatus = match($researchSubmission->final_status) {
                                            'submitted' => 'Not Accepted',
                                            'under_review' => 'Under Review',
                                            'rejected' => 'Rejected',
                                            'revision_required' => 'Revision Required',
                                            'accepted' => 'Accepted',
                                            default => 'Unknown'
                                        };

                                        $style = $statusStyles[$researchSubmission->final_status] ?? [
                                            'text' => 'text-gray-800',
                                            'bg' => 'bg-gray-100'
                                        ];
                                    ?>
                                    <span class="px-3 py-1 text-xs font-medium <?php echo e($style['text']); ?> <?php echo e($style['bg']); ?> rounded-full">
                                        <?php echo e($currentStatus); ?>

                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                <div x-data="{ isOpen: false, isRejectModalOpen: false }" class="flex justify-center space-x-1.5">
                                    <form action="<?php echo e(route('accept.proposal')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="serial_number" value="<?php echo e($researchSubmission->serial_number); ?>">
                                        <button type="submit" 
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Accept
                                        </button>
                                    </form>

                                    <form action="<?php echo e(route('reject.proposal')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="serial_number" value="<?php echo e($researchSubmission->serial_number); ?>">
                                        <button type="button" 
                                            @click="isRejectModalOpen = true"
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Reject
                                        </button>

                                        <!-- Rejection Modal Backdrop -->
                                        <div x-show="isRejectModalOpen"
                                            x-cloak 
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 bg-black bg-opacity-50 z-40">
                                        </div>

                                        <!-- Rejection Modal Container -->
                                        <div x-show="isRejectModalOpen"
                                            x-cloak
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 translate-y-4"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 translate-y-4"
                                            class="fixed inset-0 z-50 overflow-y-auto"
                                            @click.away="isRejectModalOpen = false">
                                                
                                            <div class="min-h-screen px-4 text-center">
                                                <!-- Modal Panel -->
                                                <div class="inline-block w-full max-w-md p-6 my-8 text-left align-middle bg-white rounded-lg shadow-xl transform transition-all">
                                                    <!-- Header -->
                                                    <div class="flex justify-between items-center pb-3 border-b">
                                                        <h3 class="text-lg font-medium text-gray-900">Reject Proposal</h3>
                                                        <button @click="isRejectModalOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <!-- Content -->
                                                    <div class="mt-4">
                                                        <label for="rejection_comment" class="block text-sm font-medium text-gray-700 mb-2">
                                                            Please provide a reason for rejection
                                                        </label>
                                                        <textarea
                                                            name="rejection_comment"
                                                            id="rejection_comment"
                                                            rows="4"
                                                            required
                                                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500"
                                                            placeholder="Enter your comments here..."
                                                        ></textarea>
                                                    </div>

                                                    <!-- Footer -->
                                                    <div class="mt-6 flex justify-end space-x-3">
                                                        <button
                                                            type="button"
                                                            @click="isRejectModalOpen = false"
                                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                                                            Cancel
                                                        </button>
                                                        <button
                                                            type="submit"
                                                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md transition-colors">
                                                            Confirm Rejection
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <a href="<?php echo e(asset('storage/' . $researchSubmission->pdf_document_path)); ?>" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                                        View Proposal
                                    </a>
                                        <button @click="isOpen = true" 
                                            class="inline-flex items-center space-x-1 px-3 py-1 text-xs text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-100 transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Preview Abstract</span>
                                        </button>

                                        <!-- Modal Backdrop -->
                                        <div x-show="isOpen"
                                            x-cloak 
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0"
                                            x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100"
                                            x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                            @click="isOpen = false">
                                        </div>

                                        <!-- Modal Container -->
                                        <div x-show="isOpen"
                                            x-cloak
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 translate-y-4"
                                            x-transition:enter-end="opacity-100 translate-y-0"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 translate-y-0"
                                            x-transition:leave-end="opacity-0 translate-y-4"
                                            class="fixed inset-0 z-50 overflow-y-auto"
                                            @click.away="isOpen = false">
                                                
                                            <div class="min-h-screen px-4 text-center">
                                                <!-- Modal Panel -->
                                                <div class="inline-block w-full max-w-4xl p-6 my-8 text-left align-middle bg-white rounded-lg shadow-xl transform transition-all">
                                                    <!-- Header -->
                                                    <div class="flex justify-between items-center pb-3 border-b">
                                                        <h3 class="text-lg font-medium text-gray-900">Research Abstract Preview</h3>
                                                        <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <!-- Content -->
                                                    <div class="mt-4 max-h-[70vh] overflow-y-auto">
                                                        <!-- Title -->
                                                        <h1 class="text-2xl font-serif text-center font-bold mb-6">
                                                            <?php echo e($researchSubmission->article_title); ?>

                                                        </h1>

                                                        <!-- Authors -->
                                                        <div class="text-center mb-8">
                                                            <?php
                                                                $authors = json_decode($researchSubmission->authors, true);
                                                            ?>
                                                            <?php if($authors && is_array($authors)): ?>
                                                                <div class="flex flex-wrap justify-center gap-1 mb-2">
                                                                    <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <span class="font-serif text-sm">
                                                                            <?php echo e($author['first_name']); ?> <?php echo e($author['middle_name'] ?? ''); ?> <?php echo e($author['surname']); ?>

                                                                            <?php if($author['is_correspondent']): ?>
                                                                                <span class="text-black-600">*</span>
                                                                            <?php endif; ?>
                                                                            <?php if(!$loop->last): ?>, <?php endif; ?>
                                                                        </span>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </div>
                                                                <!-- Affiliation -->
                                                                <div class="space-y-1 text-gray-600">
                                                                    <p class="font-serif text-xs"><?php echo e($authors[0]['university']); ?></p>
                                                                    <p class="font-serif text-xs"><?php echo e($authors[0]['department']); ?></p>
                                                                </div>
                                                            <?php else: ?>
                                                                <p class="text-gray-500 italic text-sm">No authors available</p>
                                                            <?php endif; ?>
                                                        </div>

                                                        <!-- Abstract -->
                                                        <div class="space-y-4">
                                                            <h2 class="text-lg font-bold text-gray-900">Abstract</h2>
                                                            <p class="text-sm text-gray-700 leading-relaxed text-justify">
                                                                <?php echo e($researchSubmission->abstract); ?>

                                                            </p>
                                                        </div>

                                                        <!-- Keywords -->
                                                        <div class="mt-6">
                                                            <h3 class="text-sm font-bold text-gray-900">Keywords</h3>
                                                            <p class="text-sm text-gray-700">
                                                                <?php echo e(implode(', ', json_decode($researchSubmission->keywords))); ?>

                                                            </p>
                                                        </div>

                                                        <!-- Sub-Theme -->
                                                        <div class="mt-4">
                                                            <h3 class="text-sm font-bold text-gray-900">Sub-Theme</h3>
                                                            <p class="text-sm text-gray-700"><?php echo e($researchSubmission->sub_theme); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
<script>
function toggleDropdown(event) {
    const button = event.currentTarget;
    const dropdown = button.nextElementSibling;

    // Close other dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        if (menu !== dropdown) menu.classList.add('hidden');
    });

    // Toggle visibility of the clicked dropdown
    dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', (event) => {
    if (!event.target.closest('.relative')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.add('hidden'));
    }
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views\admin\partials\dashboard.blade.php ENDPATH**/ ?>