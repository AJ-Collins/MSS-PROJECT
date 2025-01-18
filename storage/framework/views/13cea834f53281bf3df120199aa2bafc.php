

<?php $__env->startSection('admin-content'); ?>
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
        <?php else: ?>
            <div class="mt-4 text-gray-500">No assessments found for this document.</div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views\admin\partials\research_assessments.blade.php ENDPATH**/ ?>