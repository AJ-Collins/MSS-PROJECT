

<?php $__env->startSection('reviewer-content'); ?>
<div class="container mx-auto p-6 space-y-6">
    <!-- Profile Header -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-4">
            <img id="profile-picture" src="https://via.placeholder.com/100" alt="Profile Picture" class="w-24 h-24 rounded-full border border-gray-200">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">John Doe</h1>
                <p class="text-sm text-gray-500">Senior Developer at Example Company</p>
            </div>
        </div>
        <button onclick="openModal('edit-profile-modal')" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            Edit Profile
        </button>
    </div>

    <!-- Personal Info Section -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Personal Information</h2>
        <div class="space-y-4">
            <p><strong class="font-semibold text-gray-700">Email:</strong> john.doe@example.com</p>
            <p><strong class="font-semibold text-gray-700">Phone:</strong> +1 234 567 890</p>
            <p><strong class="font-semibold text-gray-700">Location:</strong> New York, USA</p>
        </div>
    </div>

    <!-- Skills Section 
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Skills</h2>
        <div class="space-x-4">
            <span class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded-full text-sm">Laravel</span>
            <span class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded-full text-sm">PHP</span>
            <span class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded-full text-sm">JavaScript</span>
            <span class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded-full text-sm">React</span>
        </div>
    </div>-->

    <!-- Experience Section -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Professional Experience</h2>
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Senior Developer - Example Company</h3>
                <p class="text-sm text-gray-500">Jan 2020 - Present</p>
                <p class="text-sm text-gray-700">Led a team of developers to build scalable web applications using Laravel and React. Enhanced the user experience and optimized performance for high-traffic applications.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Web Developer - Tech Solutions</h3>
                <p class="text-sm text-gray-500">Jan 2018 - Dec 2019</p>
                <p class="text-sm text-gray-700">Developed dynamic websites and applications using PHP, JavaScript, and SQL. Focused on creating efficient, user-friendly interfaces and improving website performance.</p>
            </div>
        </div>
    </div>

    <!-- Education Section -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Education</h2>
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Bachelor of Science in Computer Science</h3>
                <p class="text-sm text-gray-500">University of New York, 2017</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Master of Science in Data Science</h3>
                <p class="text-sm text-gray-500">Stanford University, 2020</p>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Contact</h2>
        <div class="space-y-4">
            <p><strong class="font-semibold text-gray-700">LinkedIn:</strong> <a href="https://linkedin.com/in/johndoe" class="text-indigo-600 hover:text-indigo-700">linkedin.com/in/johndoe</a></p>
            <p><strong class="font-semibold text-gray-700">GitHub:</strong> <a href="https://github.com/johndoe" class="text-indigo-600 hover:text-indigo-700">github.com/johndoe</a></p>
        </div>
    </div>

    <!-- Modals (for editing profile, etc.) -->
    <!-- Edit Profile Modal -->
    <div id="edit-profile-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Edit Profile</h3>
            <form>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 p-2 w-full border border-gray-300 rounded-md" value="john.doe@example.com">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" id="phone" name="phone" class="mt-1 p-2 w-full border border-gray-300 rounded-md" value="+1 234 567 890">
                </div>
                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" id="location" name="location" class="mt-1 p-2 w-full border border-gray-300 rounded-md" value="New York, USA">
                </div>
                <div class="mb-4">
                    <label for="profile-picture-upload" class="block text-sm font-medium text-gray-700">Upload Profile Picture</label>
                    <input type="file" id="profile-picture-upload" class="mt-1 p-2 w-full border border-gray-300 rounded-md" accept="image/*" onchange="previewProfilePicture(event)">
                </div>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function previewProfilePicture(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('profile-picture').src = e.target.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('reviewer.layouts.reviewer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\email-verification-app\resources\views/reviewer/partials/profile.blade.php ENDPATH**/ ?>