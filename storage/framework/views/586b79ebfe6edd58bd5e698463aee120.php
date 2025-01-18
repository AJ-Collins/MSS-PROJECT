

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
                                                <?php echo e($submission->approved == true ? 'Approved' : 'Not Approved'); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-2">
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
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
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
                                                <?php echo e($researchSubmission->approved == true ? 'Approved' : 'Not Approved'); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-2">
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
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Modal functionality
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Chart Configurations
        const chartConfig = {
            submissionTrends: {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                    datasets: [{
                        label: 'Submissions',
                        data:,
                        borderColor: 'rgb(79, 70, 229)',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 2]
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            },
            approvalRates: {
                type: 'doughnut',
                data: {
                    labels: ['Approved', 'Pending', 'Rejected'],
                    datasets: [{
                        data: [70, 20, 10],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(234, 179, 8, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    }
                }
            },
            averageMarks: {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                    datasets: [{
                        label: 'Average Marks',
                        data: [75, 82, 78, 85, 80],
                        backgroundColor: 'rgba(79, 70, 229, 0.8)',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 2]
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            }
        };

        // Initialize Charts
        document.addEventListener('DOMContentLoaded', function() {
            // Submission Trends Chart
            new Chart(
                document.getElementById('submissionTrendsChart').getContext('2d'),
                chartConfig.submissionTrends
            );

            // Approval Rates Chart
            new Chart(
                document.getElementById('approvalRatesChart').getContext('2d'),
                chartConfig.approvalRates
            );

            // Average Marks Chart
            new Chart(
                document.getElementById('averageMarksChart').getContext('2d'),
                chartConfig.averageMarks
            );
        });

        // Add smooth scrolling to all charts
        document.querySelectorAll('canvas').forEach(canvas => {
            canvas.style.transition = 'all 0.3s ease';
        });
    </script>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/admin/partials/reports.blade.php ENDPATH**/ ?>