

<?php $__env->startSection('user-content'); ?>
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">| Submissions Portal</h1>
    <p class="mt-2 text-sm text-gray-600">Choose your submission type to begin the application process</p>
</div>

    <!-- Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Conference Card -->
        <!-- Conference Card -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-300 transition-transform transform hover:scale-[1.02]">
            <h2 class="text-xl font-bold text-gray-800 mb-4">TUM 6TH MULTIDISCIPLINARY CONFERENCE</h2>
            <ul class="space-y-2 text-gray-600 mb-6">
                <li class="flex items-center">
                    <i data-lucide="calendar" class="h-5 w-5 mr-3 text-blue-500"></i>
                    Event Date: TBD
                </li>
                <li class="flex items-center">
                    <i data-lucide="users" class="h-5 w-5 mr-3 text-blue-500"></i>
                    Participants: TBD
                </li>
                <li class="flex items-center">
                    <i data-lucide="info" class="h-5 w-5 mr-3 text-blue-500"></i>
                    Additional Details Coming Soon
                </li>
            </ul>
            <a href="<?php echo e(route('user.step1')); ?>"
                class="block w-full py-3 text-center text-white font-medium rounded-lg bg-blue-500 hover:bg-blue-600">
                Submit Conference Paper
            </a>
        </div>

        <!-- Research Funding Card -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-300 transition-transform transform hover:scale-[1.02]">
            <h2 class="text-xl font-bold text-gray-800 mb-4">INTERNAL RESEARCH FUNDING FOR 2024</h2>
            <ul class="space-y-2 text-gray-600 mb-6">
                <li class="flex items-center">
                    <i data-lucide="calendar" class="h-5 w-5 mr-3 text-green-500"></i>
                    Application Deadline: TBD
                </li>
                <li class="flex items-center">
                    <i data-lucide="info" class="h-5 w-5 mr-3 text-green-500"></i>
                    Details to Be Announced
                </li>
                <li class="flex items-center">
                    <i data-lucide="info" class="h-5 w-5 mr-3 text-blue-500"></i>
                    Additional Details Coming Soon
                </li>
            </ul>
            <a href="<?php echo e(route('user.step1_research')); ?>"
                class="block w-full py-3 text-center text-white font-medium rounded-lg bg-green-500 hover:bg-green-600">
                Submit Proposal Paper
            </a>
        </div>


    
    </div>

    <!-- Help Section -->
    <div class="text-center mt-8">
        <p class="text-sm text-gray-600">
            Need help? Contact our support team at 
            <a href="mailto:support@tum.ac.ke" class="text-blue-600 hover:text-blue-700">support@tum.ac.ke</a>
        </p>
    </div>

<script>
    lucide.createIcons();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\email-verification-app\resources\views/user/partials/submit.blade.php ENDPATH**/ ?>