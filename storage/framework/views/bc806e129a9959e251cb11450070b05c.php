<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">| Dashboard</h1>
    <!--<p class="mt-2 text-sm text-gray-600">Welcome back to your research dashboard</p>-->
</div>

<!-- Stats Cards -->                
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stats Card 1 -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">My Abstracts</p>
                <p class="text-2xl font-semibold text-gray-700"><?php echo e($totalAbstracts); ?></p>
            </div>
        </div>
    </div>

    <!-- Stats Card 2 -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Published Articles</p>
                <p class="text-2xl font-semibold text-gray-700"><?php echo e($totalArticles); ?></p>
            </div>
        </div>
    </div>

    <!-- Stats Card 3 -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Research Proposals</p>
                <p class="text-2xl font-semibold text-gray-700"><?php echo e($totalResearchSubmissions); ?></p>
            </div>
        </div>
    </div>

    <!-- Stats Card 4 -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Pending Reviews</p>
                <p class="text-2xl font-semibold text-gray-700"><?php echo e($totalPendingCount); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Document Management Section -->
<div x-data="{ activeTab: 'abstracts' }">
        <div class="border-b border-gray-200 shadow-sm bg-white">
            <h2 class="text-2xl font-semibold text-gray-800 tracking-tight p-4">Recents</h2>
        </div>

        <!-- Tabs -->
        <div class="bg-white border-b border-gray-200">
        <div class="flex items-center space-x-4">
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
        <a href="<?php echo e(route('user.drafts')); ?>" class="flex items-center text-indigo-600 hover:text-indigo-900 text-sm font-medium" title="Continue to submit your drafts">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
            Continue submission
        </a>
    </div>
        
</div>
    

    <!-- Tab Contents -->
    <div class="bg-white shadow-sm">
        <!-- Abstracts Tab -->
        <div x-show="activeTab === 'abstracts'" class="overflow-x-auto">
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                    <p class="font-medium"><?php echo e(session('success')); ?></p>
                </div>
            <?php endif; ?>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <!--<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>-->
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($submission->title); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e(\Carbon\Carbon::parse($submission->created_at)->format('d M Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($submission->score); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $AbstractStatus = [
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Approved' => 'bg-green-100 text-green-800',
                                        'Rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $AbstractStatus = $AbstractStatus[$submission->final_status ?? 'Pending'] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($AbstractStatus); ?>">
                                    <?php echo e($submission->final_status ?? 'Pending'); ?>

                                </span>
                            </td>
                            <!--<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <?php if($draft && $draft->serial_number): ?>
                                    <a href="<?php echo e(route('user.drafts', ['serialNumber' => $draft->serial_number])); ?>"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        Continue submission
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-500">No draft available</span>
                                <?php endif; ?>
                            </td>-->
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                  
                </tbody>
            </table>
        </div>
        <!-- Research Proposals Tab -->
        <div x-show="activeTab === 'proposals'" class="overflow-x-auto">
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                    <p class="font-medium"><?php echo e(session('success')); ?></p>
                </div>
            <?php endif; ?>
        <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <!--<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>-->
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $researchSubmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $researchSubmission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($researchSubmission->article_title); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e(\Carbon\Carbon::parse($researchSubmission->created_at)->format('d M Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($researchSubmission->score); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $statusClasses = [
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Approved' => 'bg-green-100 text-green-800',
                                        'Rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusClass = $statusClasses[$researchSubmission->final_status ?? 'Pending'] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($statusClass); ?>">
                                    <?php echo e($researchSubmission->final_status ?? 'Pending'); ?>

                                </span>
                            </td>
                            <!--<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">view</a>
                            </td>-->
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                   
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/user/partials/dashboard.blade.php ENDPATH**/ ?>