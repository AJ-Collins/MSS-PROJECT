<?php $__env->startSection('reviewer-content'); ?>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Rivisions</p>
                                <p class="text-2xl font-semibold text-gray-700">3</p>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Document Management Section -->
<div x-data="{ activeTab: 'articles' }">
    <div class="border-b border-gray-200 shadow-sm bg-white">
        <h2 class="text-2xl font-semibold text-gray-800 tracking-tight p-4">Document Management</h2>
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
                                <?php echo e($submission->reviewer_status === null || $submission->reviewer_status === '' ? 'NotAccepted' : $submission->reviewer_status); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <button 
                                class="px-2 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full"
                                
                                @click="$store.modal.open({ serial_number: '<?php echo e($submission->serial_number); ?>' })"
                            >
                                Review
                            </button>
                            <a href="<?php echo e(route('research.abstract.download', $submission->serial_number)); ?>" class="px-2 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">
                                Download
                            </a>
                        </td>
                        
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                    <td colspan="3" class="px-4 py-2 text-center">No abstracts assigned yet.</td>
                </tr>
            <?php endif; ?>
                </tbody>
            </table>
            <div 
                x-data="{ zoomLevel: 100 }"
                x-show="$store.modal.isOpen"
                @keydown.escape.window="$store.modal.close()"
                class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-50"
                style="display: none;"
            >
                <div class="min-h-screen w-full flex items-center justify-center p-4">
                    <div 
                        class="w-full md:w-1/2 max-h-[90vh] flex flex-col bg-gray-50 rounded-lg shadow-lg relative"
                        @click.away="$store.modal.close()"
                    >
                        <!-- Header -->
                        <div class="flex-none bg-white border-b border-gray-200 sticky top-0 z-10">
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Abstract Preview</h2>
                                </div>
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

                        <!-- Document Viewer -->
                        <div class="flex-1 overflow-y-auto p-8 bg-white">
                            <div class="max-w-3xl mx-auto space-y-6">
                                <template x-if="$store.modal.abstract">
                                    <div class="space-y-6  pt-10">
                                        <h1 
                                            x-text="$store.modal.abstract.title"
                                            class="text-2xl font-bold text-center text-gray-900"
                                        ></h1>
                                        <ul class="list-none text-center text-sm text-gray-700">
                                            <template x-for="author in $store.modal.abstract?.authors || []" :key="author.email">
                                                <li x-text="`${author.first_name} ${author.middle_name || ''} ${author.surname}`"></li>
                                            </template>
                                        </ul>
                                        <h2 class="text-lg font-bold text-gray-900 mt-8">ABSTRACT</h2>
                                        <p 
                                            x-text="$store.modal.abstract.content"
                                            class="text-gray-700 leading-relaxed text-justify"
                                        ></p>
                                        <div class="mt-6">
                                            <h3 class="font-bold text-gray-900">Keywords</h3>
                                            <p x-text="$store.modal.abstract.keywords || 'Not available'" class="text-gray-700"></p>
                                        </div>
                                        <div class="mt-4">
                                            <h3 class="font-bold text-gray-900">Sub-Theme</h3>
                                            <p x-text="$store.modal.abstract.sub_theme || 'Not available'" class="text-gray-700"></p>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="!$store.modal.abstract">
                                    <div class="text-center">
                                        <p class="text-sm text-gray-500">Loading...</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="flex-none bg-white border-t border-gray-200 px-6 py-4 sticky bottom-0 z-10">
                            <div class="flex justify-end space-x-2">
                            <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <form action="<?php echo e(route('update.abstract.reviewer.status')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="serial_number" value="<?php echo e($submission->serial_number); ?>">
                                <input type="hidden" name="reviewer_status" value="accepted">
                                <button type="submit" class="px-2 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">
                                    Accept
                                </button>
                            </form>
                            <form action="<?php echo e(route('reviewer.abstract.reject')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="serial_number" value="<?php echo e($submission->serial_number); ?>">
                                <button type="submit" class="px-2 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-full">
                                    Reject
                                </button>
                            </form>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Research Proposals Tab (Similar Layout as Abstracts) -->
        <div x-show="activeTab === 'proposals'" class="p-4">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
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
                                <?php echo e($researchSubmission->reviewer_status === null || $researchSubmission->reviewer_status === '' ? 'NotAccepted' : $researchSubmission->reviewer_status); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <button 
                                class="px-2 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full"
                                @click="$store.proposalModal.open({ serial_number: '<?php echo e($researchSubmission->serial_number); ?>' })"
                            >
                                Review
                            </button>
                            <a href="<?php echo e(route('proposal.abstract.download', $researchSubmission->serial_number)); ?>" class="px-2 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">
                                Download
                            </a>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center">No proposals assigned yet.</td>
                        </tr>
                        <?php endif; ?>
                </tbody>
            </table>
            <div 
                x-data="{ zoomLevel: 100 }"
                x-show="$store.proposalModal.isOpen"
                @keydown.escape.window="$store.proposalModal.close()"
                class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-50"
                style="display: none;"
            >
                <div class="min-h-screen w-full flex items-center justify-center p-4">
                    <div 
                        class="w-full md:w-1/2 max-h-[90vh] flex flex-col bg-gray-50 rounded-lg shadow-lg relative"
                        @click.away="$store.proposalModal.close()"
                    >
                        <!-- Header -->
                        <div class="flex-none bg-white border-b border-gray-200 sticky top-0 z-10">
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Proposal Preview</h2>
                                </div>
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

                        <!-- Document Viewer -->
                        <div class="flex-1 overflow-y-auto p-8 bg-white">
                        <div class="max-w-3xl mx-auto space-y-6">
                                <template x-if="$store.proposalModal.proposal">
                                    <div class="space-y-6  pt-10">
                                        <h1 
                                            x-text="$store.proposalModal.proposal.title"
                                            class="text-2xl font-bold text-center text-gray-900"
                                        ></h1>
                                        <ul class="list-none text-center text-sm text-gray-700">
                                            <template x-for="author in $store.proposalModal.proposal?.authors || []" :key="author.email">
                                                <li x-text="`${author.first_name} ${author.middle_name || ''} ${author.surname}`"></li>
                                            </template>
                                        </ul>
                                        <h2 class="text-lg font-bold text-gray-900 mt-8">PROPOSAL ABSTRACT</h2>
                                        <p 
                                            x-text="$store.proposalModal.proposal.content"
                                            class="text-gray-700 leading-relaxed text-justify"
                                        ></p>
                                        <div class="mt-6">
                                            <h3 class="font-bold text-gray-900">Keywords</h3>
                                            <p x-text="$store.proposalModal.proposal.keywords || 'Not available'" class="text-gray-700"></p>
                                        </div>
                                        <div class="mt-4">
                                            <h3 class="font-bold text-gray-900">Sub-Theme</h3>
                                            <p x-text="$store.proposalModal.proposal.sub_theme || 'Not available'" class="text-gray-700"></p>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="!$store.proposalModal.proposal">
                                    <div class="text-center">
                                        <p class="text-sm text-gray-500">Loading...</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="flex-none bg-white border-t border-gray-200 px-6 py-4 sticky bottom-0 z-10">
                            <div class="flex justify-end space-x-2">
                            <?php $__empty_1 = true; $__currentLoopData = $researchSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researchSubmission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <form action="<?php echo e(route('update.proposal.reviewer.status')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="serial_number" value="<?php echo e($researchSubmission->serial_number); ?>">
                                    <input type="hidden" name="reviewer_status" value="accepted">
                                    <button type="submit" class="px-2 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">
                                        Accept
                                    </button>
                                </form>
                                <form action="<?php echo e(route('reviewer.proposal.reject')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="serial_number" value="<?php echo e($researchSubmission->serial_number); ?>">
                                    <button type="submit" class="px-2 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-full">
                                        Reject
                                    </button>
                                </form>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    title: data.title,
                    content: data.abstract,
                    keywords: data.keywords,
                    sub_theme: data.sub_theme,
                    authors: data.authors
                };
            } catch (error) {
                console.error('Error fetching abstract:', error);
                this.abstract = {
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
                    title: data.title,
                    content: data.abstract,
                    keywords: data.keywords,
                    sub_theme: data.sub_theme,
                    authors: data.authors
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
<?php echo $__env->make('reviewer.layouts.reviewer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\email-verification-app\resources\views/reviewer/partials/dashboard.blade.php ENDPATH**/ ?>