

<?php $__env->startSection('admin-content'); ?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Profile Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
            <p class="mt-2 text-sm text-gray-600">Account information</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Profile Photo Section -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col items-center">
                        <div class="relative group">
                            <div class="w-40 h-40 rounded-full overflow-hidden ring-4 ring-gray-100">
                                <img 
                                    id="profileImagePreview" 
                                    src="<?php echo e(asset('storage/' . $user->profile_photo_url ?? 'default-profile.png')); ?>" 
                                    alt="Profile Photo" 
                                    class="w-full h-full object-cover transition duration-300 ease-in-out group-hover:opacity-75"
                                >
                            </div>
                            <label for="profilePhotoInput" class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-lg cursor-pointer transform transition duration-300 ease-in-out hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                            <input type="file" name="profile_photo" id="profilePhotoInput" accept="image/*" onchange="uploadPhoto(event)" class="hidden">
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900"><?php echo e($user->first_name . ' ' .auth()->user()->last_name); ?></h3>
                        <p class="text-sm text-gray-500"><?php echo e($user->email); ?></p>
                    </div>
                </div>
            </div>

            <!-- Right Column: User Details Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">Personal Information</h2>
                        
                        <dl class="mt-6 space-y-6 divide-y divide-gray-200">
                            <div class="pt-6">
                                <dt class="text-sm font-medium text-gray-500">Registration Number</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->reg_no); ?></dd>
                            </div>
                            <div class="pt-6 first:pt-0">
                                <dt class="text-sm font-medium text-gray-500">First Name</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->first_name); ?></dd>
                            </div>

                            <div class="pt-6">
                                <dt class="text-sm font-medium text-gray-500">Middle Name</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->last_name); ?></dd>
                            </div>

                            <div class="pt-6">
                                <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->email); ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Additional Information Card
                <div class="mt-8 bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">Account Settings</h2>
                        <p class="mt-1 text-sm text-gray-500">Manage your account preferences and settings.</p>
                        
                        <div class="mt-6">
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Change Password
                            </a>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</div>

<script>
function uploadPhoto(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Show loading state
    const preview = document.getElementById('profileImagePreview');
    preview.style.opacity = '0.5';

    // Preview image
    const reader = new FileReader();
    reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.opacity = '1';
    };
    reader.readAsDataURL(file);

    // Prepare form data
    const formData = new FormData();
    formData.append('profile_photo', file);
    formData.append('_token', '<?php echo e(csrf_token()); ?>');

    // Upload to server
    fetch('<?php echo e(route('upload.profile.photo')); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success notification using custom function
            showNotification('Profile photo updated successfully', 'success');
        } else {
            showNotification('Error uploading photo', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while uploading the photo', 'error');
        // Reset preview to previous image if upload failed
        preview.src = '<?php echo e(auth()->user()->profile_photo_url); ?>';
    })
    .finally(() => {
        preview.style.opacity = '1';
    });
}

// Function to show notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out opacity-0 z-50`;
    
    const colors = {
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        success: 'bg-green-500',
        info: 'bg-blue-500'
    };
    
    notification.classList.add(colors[type], 'text-white');
    notification.textContent = message;
    document.body.appendChild(notification);

    // Animate in
    requestAnimationFrame(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateY(0)';
    });

    // Auto-dismiss after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(20px)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/admin/partials/profile.blade.php ENDPATH**/ ?>