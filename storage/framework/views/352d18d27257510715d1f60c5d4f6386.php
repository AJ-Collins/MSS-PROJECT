

<?php $__env->startSection('admin-content'); ?>
<div class="px-6 py-4 border-b border-gray-200 shadow-sm bg-white">
    <h2 class="text-2xl font-semibold text-gray-800 tracking-tight">Document Management</h2>
</div>
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

    <!-- Abstracts Tab Content -->
    <div x-show="activeTab === 'abstracts'">
        <div class="mt-6 px-6 py-4 bg-white rounded-lg shadow-md border border-gray-200">
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                    <p class="font-medium"><?php echo e(session('success')); ?></p>
                </div>
            <?php endif; ?>
        <!-- Search and Filter Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0 md:space-x-4">
            <div class="w-full md:w-4/4">
                <input 
                    type="text" 
                    placeholder="Search documents..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                >
            </div>
            <button class="w-full md:w-auto px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                Search
            </button>
        </div>
        <div class="flex justify-between items-center mb-4">
            <!-- Bulk Selection -->
            <div class="flex items-center space-x-2">
                <input type="checkbox" id="select-all-abstracts" 
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded"
                    onclick="toggleSelectAllAbstracts(this)">
                <label for="select-all-abstracts" class="text-sm text-gray-700">Select All</label>
            </div>

            <!-- Reviewer Selection and Assign Button -->
            <div class="flex items-center space-x-4">
                <select id="reviewer-dropdown" 
                        name="reviewer" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        required>
                    <option value="">Select Reviewer</option>
                    <?php $__currentLoopData = $reviewers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviewer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($reviewer->reg_no); ?>"><?php echo e($reviewer->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button onclick="assignAbstractReviewers()" 
                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                    Assign Reviewer
                </button>
            </div>
        </div>
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th><input type="checkbox" class="abstract-submission-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded"></th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>                 
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Submitted By</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Submission Date</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Score</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Reviewer</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Related Documents</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">
                        <input type="checkbox" class="abstract-submission-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded" 
                            value="<?php echo e($submission->serial_number); ?>">
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        <div class="font-medium"><?php echo e($submission->title); ?></div>
                        <div class="text-xs text-gray-500"><?php echo e($submission->serial_number); ?></div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($submission->user_reg_no); ?></td>
                    <td class="px-4 py-3 text-sm text-gray-500"><?php echo e(\Carbon\Carbon::parse($submission->created_at)->format('d M Y')); ?></td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        <?php if(!$submission->score): ?>
                            Not reviewed
                        <?php else: ?>
                            <?php echo e($submission->score); ?>

                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        <?php if($submission->reviewer_reg_no && $submission->reviewer_name): ?>
                            <?php
                                $firstName = explode(' ', $submission->reviewer_name)[0];
                            ?>
                            <span><?php echo e($firstName); ?></span>
                            <!-- Form for removing reviewer -->
                            <form action="<?php echo e(route('remove.abstract.reviewer', $submission->serial_number)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('POST'); ?>
                                <button type="submit" class="ml-2 text-red-500 hover:text-red-700" title="Remove Reviewer">
                                    X
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="text-red-500">Not assigned</span>
                        <?php endif; ?>
                    </td>
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
                                ]
                            ];
                            $currentStatus = $submission->final_status;
                            $style = $statusStyles[$currentStatus] ?? [
                                'text' => 'text-gray-800',
                                'bg' => 'bg-gray-100'
                            ];
                        ?>
                        <span class="px-3 py-1 text-xs font-medium <?php echo e($style['text']); ?> <?php echo e($style['bg']); ?> rounded-full">
                            <?php echo e($currentStatus ?: 'Unknown'); ?>

                        </span>
                    </td>                    
                    <td class="px-4 py-3 text-center">
                        <?php if($submission->score): ?>
                            <form action="<?php echo e(route('request.article.upload', $submission->serial_number)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" 
                                        class="inline-block px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full">
                                    Request Article
                                </button>
                            </form>
                        <?php elseif($submission->article): ?>
                            <a href="" target="_blank" 
                            class="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                                View Article
                            </a>
                        <?php else: ?>
                            <span class="text-xs text-gray-500">No article submitted yet</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2 justify-center">
                            <div class="dropdown relative">
                                <button onclick="toggleDropdown('actions-dropdown-<?php echo e($submission->serial_number); ?>')" 
                                        class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full">
                                    Actions ▼
                                </button>
                                <div id="actions-dropdown-<?php echo e($submission->serial_number); ?>" 
                                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10">
                                    <div class="py-1">
                                        <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                                onclick="openModal('assign-reviewer-modal-<?php echo e($submission->serial_number); ?>')">
                                                Assign Reviewer
                                        </button>
                                        <form action="<?php echo e(route('approve.abstract')); ?>" method="POST" class="contents">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="serial_number" value="<?php echo e($submission->serial_number); ?>">
                                            <button type="submit" 
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Accept
                                            </button>
                                        </form>
                                        <a href="<?php echo e(route('research.abstract.download', $submission->serial_number)); ?>" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Download PDF
                                        </a>
                                        <a href="<?php echo e(route('abstract.abstractWord.download', $submission->serial_number)); ?>" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Download Word
                                        </a>
                                        <button class="block w-full text-left px-4 py-2 text-sm text-green-900 hover:bg-gray-100">
                                            Return for Revision
                                        </button>
                                        <button class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100" 
                                                onclick="openModal('add-comments-modal-<?php echo e($submission->serial_number); ?>')">
                                            Reject
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Rejection Modal -->
                <div id="add-comments-modal-<?php echo e($submission->serial_number); ?>" 
                    class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Add Comments for Rejecting</h3>
                        <form action="<?php echo e(route('reject.abstract')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="serial_number" value="<?php echo e($submission->serial_number); ?>">
                            <textarea 
                                name="comments"
                                rows="4" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                                placeholder="Write your comments here..."
                                required></textarea>
                            <div class="mt-4 flex justify-end">
                                <button type="button" 
                                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-2" 
                                        onclick="closeModal('add-comments-modal-<?php echo e($submission->serial_number); ?>')">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Reject
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                 <!-- Modal for Assigning Reviewer -->
                 <div id="assign-reviewer-modal-<?php echo e($submission->serial_number); ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Assign Reviewer</h3>
                        <form action="<?php echo e(route('assign.abstract.reviewer', $submission->serial_number)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <select name="reg_no" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none mb-4" 
                                    required>
                                <option value="">Select Reviewer</option>
                                <?php $__currentLoopData = $reviewers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviewer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($reviewer->reg_no); ?>"><?php echo e($reviewer->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="mt-4 flex justify-end">
                                <button type="button" 
                                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-2" 
                                        onclick="closeModal('assign-reviewer-modal-<?php echo e($submission->serial_number); ?>')">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Assign
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        </div>
    </div>





    <!-- Research Proposals Tab Content -->
    <div x-show="activeTab === 'proposals'">
         <div class="mt-6 px-6 py-4 bg-white rounded-lg shadow-md border border-gray-200">
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                    <p class="font-medium"><?php echo e(session('success')); ?></p>
                </div>
            <?php endif; ?>
        <!-- Search and Filter Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0 md:space-x-4">
            <div class="w-full md:w-4/4">
                <input 
                    type="text" 
                    placeholder="Search documents..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                >
            </div>
            <button class="w-full md:w-auto px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                Search
            </button>
        </div>
        <div class="flex justify-between items-center mb-4">
    <!-- Bulk Selection -->
    <div class="flex items-center space-x-2">
        <input type="checkbox" id="select-all-proposals" 
               class="w-4 h-4 text-indigo-600 border-gray-300 rounded"
               onclick="toggleSelectAllProposals(this)">
        <label for="select-all-proposals" class="text-sm text-gray-700">Select All</label>
    </div>

    <!-- Reviewer Selection and Assign Button -->
    <div class="flex items-center space-x-4">
        <select id="proposal-reviewer-dropdown" 
                name="reviewer" 
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                required>
            <option value="">Select Reviewer</option>
            <?php $__currentLoopData = $reviewers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviewer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($reviewer->reg_no); ?>"><?php echo e($reviewer->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button onclick="assignReviewers()" 
                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
            Assign Reviewer
        </button>
    </div>
</div>
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">
                        <input type="checkbox" id="select-all" class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Submitted By</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Submission Date</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Score</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Reviewer</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Related Documents</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $researchSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researchSubmission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">
                        <input type="checkbox" class="proposal-submission-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded" 
                            value="<?php echo e($researchSubmission->serial_number); ?>">
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        <div class="font-medium"><?php echo e($researchSubmission->article_title); ?></div>
                        <div class="text-xs text-gray-500"><?php echo e($researchSubmission->serial_number); ?></div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700"><?php echo e($researchSubmission->user_reg_no); ?></td>
                    <td class="px-4 py-3 text-sm text-gray-500"><?php echo e(\Carbon\Carbon::parse($researchSubmission->created_at)->format('d M Y')); ?></td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        <?php if(!$researchSubmission->score): ?>
                            Not reviewed
                        <?php elseif($researchSubmission->score < 30): ?>
                            Below Average
                        <?php else: ?>
                            <?php echo e($researchSubmission->score); ?>

                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        <?php if($researchSubmission->reviewer_reg_no && $researchSubmission->reviewer_name): ?>
                            <?php
                                $firstName = explode(' ', $researchSubmission->reviewer_name)[0];
                            ?>
                            <span><?php echo e($firstName); ?></span>
                            <!-- Form for removing reviewer -->
                            <form action="<?php echo e(route('remove.proposal.reviewer', $researchSubmission->serial_number)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('POST'); ?>
                                <button type="submit" class="ml-2 text-red-500 hover:text-red-700" title="Remove Reviewer">
                                    X
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="text-red-500">Not assigned</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <?php
                            $statusStyles = [
                                'Pending' => [
                                    'text' => 'text-yellow-800',
                                    'bg' => 'bg-yellow-100'
                                ],
                                'Approved' => [
                                    'text' => 'text-green-800',
                                    'bg' => 'bg-green-100'
                                ],
                                'Under Review' => [
                                    'text' => 'text-blue-800',
                                    'bg' => 'bg-blue-100'
                                ],
                                'Rejected' => [
                                    'text' => 'text-red-800',
                                    'bg' => 'bg-red-100'
                                ],
                                'Needs Revision' => [
                                    'text' => 'text-orange-800',
                                    'bg' => 'bg-orange-100'
                                ]
                            ];

                            $currentStatus = $researchSubmission->final_status;
                            $style = $statusStyles[$currentStatus] ?? [
                                'text' => 'text-gray-800',
                                'bg' => 'bg-gray-100'
                            ];
                        ?>

                        <span class="px-3 py-1 text-xs font-medium <?php echo e($style['text']); ?> <?php echo e($style['bg']); ?> rounded-full">
                            <?php echo e($currentStatus ?: 'Unknown'); ?>

                        </span>
                    </td>
                    <td class="relative" x-data="{ isOpen: false }">
                        <style>
                            .modal-backdrop {
                            position: fixed;
                            inset: 0;
                            background-color: rgba(0, 0, 0, 0.5);
                            backdrop-filter: blur(4px);
                            z-index: 40;
                            }

                            .modal-container {
                            position: fixed;
                            inset: 0;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            padding: 1rem;
                            z-index: 50;
                            }

                            .modal-content {
                            background: white;
                            border-radius: 0.5rem;
                            width: 100%;
                            max-width: 900px;
                            max-height: 90vh;
                            overflow-y: auto;
                            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
                            }

                            .preview-button {
                            display: inline-flex;
                            align-items: center;
                            gap: 0.25rem;
                            color: #2563eb;
                            font-size: 0.875rem;
                            cursor: pointer;
                            background: none;
                            border: none;
                            padding: 0;
                            }

                            .preview-button:hover {
                            color: #1e40af;
                            text-decoration: underline;
                            }

                            .modal-header {
                            padding: 1rem;
                            border-bottom: 1px solid #e5e7eb;
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            background-color: #f9fafb;
                            }

                            .modal-body {
                            padding: 1.5rem;
                            }

                            .close-button {
                            color: #6b7280;
                            cursor: pointer;
                            background: none;
                            border: none;
                            padding: 0;
                            }

                            .close-button:hover {
                            color: #374151;
                            }
                        </style>

                        <!-- Preview Button -->
                        <button @click="isOpen = true" class="preview-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Preview Document
                        </button>

                        <!-- Modal -->
                        <div x-show="isOpen" class="modal-backdrop" @click="isOpen = false"></div>

                        <!-- Modal Container -->
                        <div x-show="isOpen" @click.away="isOpen = false" class="modal-container">
                            <div class="modal-content" @click.stop>
                            <!-- Header -->
                            <div class="modal-header">
                                <span class="text-sm text-gray-600">Research Abstract Preview</span>
                                <button @click="isOpen = false" class="close-button" aria-label="Close preview">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                </button>
                            </div>

                            <!-- Content -->
                            <div class="modal-body">
                                <!-- Replace this section with your actual document content -->
                                <div class="space-y-4">
                                <div class="flex-1 overflow-y-auto p-8 bg-white">
                                    <div class="max-w-3xl mx-auto space-y-6">
                                    <!-- Title -->
                                    <h1 class="text-2xl font-serif text-center font-bold mb-6 leading-tight">
                                        <?php echo e($researchSubmission->article_title); ?>

                                    </h1>

                                    <!-- Authors -->
                                    <div class="text-center mb-8 space-y-2">
                                        <?php
                                            $authors = json_decode($researchSubmission->authors, true);
                                        ?>
                                        <?php if($authors && is_array($authors)): ?>
                                            <div class="flex justify-center space-x-4 mb-4">
                                            <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="font-serif">
                                                    <?php echo e($author['first_name']); ?> <?php echo e($author['middle_name'] ?? ''); ?> <?php echo e($author['surname']); ?>

                                                    <?php if($author['is_correspondent']): ?>
                                                        <span>*</span>
                                                    <?php endif; ?>
                                                </span>
                                                <?php if(!$loop->last): ?>
                                                    <span>,</span>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <!-- University/Affiliation -->
                                                <div class="flex flex-col items-center space-y-1">
                                                    <p class="font-serif"><?php echo e($author['university']); ?></p>
                                                    <p class="font-serif"><?php echo e($author['department']); ?></p>
                                                </div>
                                        <?php else: ?>
                                            <p class="text-gray-600 italic">No authors available</p>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Abstract -->
                                    <h2 class="text-lg font-bold text-gray-900 mt-8">Abstract</h2>
                                    <p class="text-gray-700 leading-relaxed text-justify">
                                        <?php echo e($researchSubmission->abstract); ?>

                                    </p>

                                    <!-- Keywords -->
                                    <div class="mt-6">
                                        <h3 class="font-bold text-gray-900">Keywords</h3>
                                        <p class="text-gray-700"><?php echo e(implode(', ', json_decode($researchSubmission->keywords))); ?></p>
                                    </div>

                                    <!-- Sub-Theme -->
                                    <div class="mt-4">
                                        <h3 class="font-bold text-gray-900">Sub-Theme</h3>
                                        <p class="text-gray-700"><?php echo e($researchSubmission->sub_theme); ?></p>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2 justify-center">
                            <div class="dropdown relative">
                                <!-- Dropdown button -->
                                <button onclick="toggleDropdown('actions-dropdown-<?php echo e($researchSubmission->serial_number); ?>')" 
                                        class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full">
                                    Actions ▼
                                </button>
                                <div id="actions-dropdown-<?php echo e($researchSubmission->serial_number); ?>" 
                                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10">
                                    <div class="py-1">
                                        <button 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            onclick="openModal('assign-reviewer-modal-<?php echo e($researchSubmission->serial_number); ?>')">
                                            Assign Reviewer</button>
                                        <form action="<?php echo e(route('approve.proposal')); ?>" method="POST" class="contents">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="serial_number" value="<?php echo e($researchSubmission->serial_number); ?>">
                                            <button type="submit" 
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Approve
                                            </button>
                                        </form>
                                        <a href="<?php echo e(route('proposal.abstract.download', $researchSubmission->serial_number)); ?>" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Download PDF
                                        </a>
                                        <a href="<?php echo e(route('proposal.abstractWord.download', $researchSubmission->serial_number)); ?>" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Download Word
                                        </a>
                                        <a href="<?php echo e(route('download.file', ['serialNumber' => $researchSubmission->serial_number])); ?>" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Download File
                                        </a>
                                        <button class="block w-full text-left px-4 py-2 text-sm text-green-900 hover:bg-gray-100">Return for Revision</button>
                                        <button class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100"
                                                onclick="openModal('add-comments-modal-<?php echo e($researchSubmission->serial_number); ?>')">
                                                Reject</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- Rejection Modal -->
                <div id="add-comments-modal-<?php echo e($researchSubmission->serial_number); ?>" 
                    class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Add Comments for Rejecting</h3>
                        <form action="<?php echo e(route('reject.proposal')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="serial_number" value="<?php echo e($researchSubmission->serial_number); ?>">
                            <textarea 
                                name="comments"
                                rows="4" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                                placeholder="Write your comments here..."
                                required></textarea>
                            <div class="mt-4 flex justify-end">
                                <button type="button" 
                                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-2" 
                                        onclick="closeModal('add-comments-modal-<?php echo e($researchSubmission->serial_number); ?>')">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Reject
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
               <!-- Modal for Assigning Reviewer -->
               <div id="assign-reviewer-modal-<?php echo e($researchSubmission->serial_number); ?>" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Assign Reviewer</h3>
                        <form action="<?php echo e(route('assign.proposal.reviewer', $researchSubmission->serial_number)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <select name="reg_no" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none mb-4" 
                                    required>
                                <option value="">Select Reviewer</option>
                                <?php $__currentLoopData = $reviewers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviewer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($reviewer->reg_no); ?>"><?php echo e($reviewer->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="mt-4 flex justify-end">
                                <button type="button" 
                                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-2" 
                                        onclick="closeModal('assign-reviewer-modal-<?php echo e($researchSubmission->serial_number); ?>')">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Assign
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>  
</div>
<script>
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }
    
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const allDropdowns = document.querySelectorAll('.dropdown div[id^="actions-dropdown-"]');
        
        // Close all other dropdowns
        allDropdowns.forEach(d => {
            if (d.id !== dropdownId) {
                d.classList.add('hidden');
            }
        });
        
        // Toggle the clicked dropdown
        dropdown.classList.toggle('hidden');
    }
    
    // Close dropdowns when clicking outside
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            const allDropdowns = document.querySelectorAll('.dropdown div[id^="actions-dropdown-"]');
            allDropdowns.forEach(d => d.classList.add('hidden'));
        }
    });
</script>
<script>
// Function to toggle the "Select All" checkbox
function toggleSelectAllAbstracts(source) {
    const checkboxes = document.querySelectorAll('.abstract-submission-checkbox');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = source.checked;
    });
}

// Function to handle assigning reviewers to selected submissions
function assignAbstractReviewers() {
    const selectedSubmissions = Array.from(document.querySelectorAll('.abstract-submission-checkbox:checked'))
        .map((checkbox) => checkbox.value); // Collect all selected submission IDs
    const selectedReviewer = document.getElementById('reviewer-dropdown').value; // Get the selected reviewer

    if (selectedSubmissions.length === 0) {
        alert('Please select at least one submission.');
        return;
    }

    if (!selectedReviewer) {
        alert('Please select a reviewer.');
        return;
    }

    // Send the selected submissions and reviewer to the server via a POST request
    fetch('<?php echo e(route('assign.mass.reviewer')); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
        },
        body: JSON.stringify({
            submissions: selectedSubmissions,
            reviewer: selectedReviewer,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                location.reload(); // Reload the page to reflect changes
            } else if (data.error) {
                alert(data.error); // Handle error if there's any
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}
 
function toggleSelectAllProposals(source) {
    const checkboxes = document.querySelectorAll('.proposal-submission-checkbox');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = source.checked;
    });
}

function assignReviewers() {
    const selected = Array.from(document.querySelectorAll('.proposal-submission-checkbox:checked'))
        .map((checkbox) => checkbox.value);

    const reviewer = document.getElementById('proposal-reviewer-dropdown').value;

    if (selected.length === 0) {
        alert('Please select at least one submission.');
        return;
    }

    if (!reviewer) {
        alert('Please select a reviewer.');
        return;
    }

    // Make a POST request to assign reviewers
    fetch('<?php echo e(route('assign.proposal.massReviewer')); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
        },
        body: JSON.stringify({
            submissions: selected,
            reviewer: reviewer,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                location.reload(); // Reload the page to reflect changes
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\email-verification-app\resources\views/admin/partials/documents.blade.php ENDPATH**/ ?>