

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">
            Manage Submission Types
        </h1>
        <button onclick="document.getElementById('createModal').classList.remove('hidden')"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add
        </button>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $submissionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php echo e($type->type === 'conference' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'); ?>">
                            <?php echo e(ucfirst($type->type)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900"><?php echo e($type->title); ?></div>
                        <div class="text-sm text-gray-500"><?php echo e(Str::limit($type->description, 50)); ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php echo e($type->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e(ucfirst($type->status)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php echo e($type->deadline->format('M d, Y')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="editSubmissionType(<?php echo e($type->id); ?>)"
                                class="text-blue-600 hover:text-blue-900 mr-3 transition-colors duration-150">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </span>
                        </button>
                        <form 
                            action="<?php echo e(route('admin.submission-types.destroy', $type->id)); ?>"
                            method="POST"
                            class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this submission type?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900 transition-colors duration-150">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </span>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- Create/Edit Modal -->
    <div id="createModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-900" id="modalTitle">Add New Submission Type</h3>
                <button onclick="document.getElementById('createModal').classList.add('hidden')"
                        class="text-gray-600 hover:text-gray-800 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="submissionForm"
                 method="POST" 
                 action="<?php echo e(route('admin.submission-types.store')); ?>" 
                 class="space-y-4">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" class="mt-1 block w-full border-2 border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="conference">Conference</option>
                            <option value="research">Research</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" class="mt-1 block w-full border-2 border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full border-2 border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full border-2 border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deadline</label>
                            <input type="datetime-local" name="deadline" class="mt-1 block w-full border-2 border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Format</label>
                        <input type="text" name="format" class="mt-1 block w-full border-2 border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Guidelines</label>
                        <textarea name="guidelines" rows="4" class="mt-1 block w-full border-2 border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" 
                                placeholder="Enter each guideline on a new line"></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button"
                            onclick="document.getElementById('createModal').classList.add('hidden')"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editSubmissionType(id) {
    fetch(`/admin/submission-types/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            // Update modal title
            document.getElementById('modalTitle').textContent = 'Edit Submission Type';
            
            // Set form action to update route
            const form = document.getElementById('submissionForm');
            form.action = `/admin/submission-types/${id}`;
            
            // Remove any existing method input
            const existingMethodInput = form.querySelector('input[name="_method"]');
            if (existingMethodInput) {
                existingMethodInput.remove();
            }
            
            // Add hidden method input for PUT request
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
            
            // Populate form fields with fetched data
            form.querySelector('[name="type"]').value = data.type;
            form.querySelector('[name="title"]').value = data.title;
            form.querySelector('[name="description"]').value = data.description;
            form.querySelector('[name="status"]').value = data.status;
            
            // Convert deadline to local datetime-local format
            const deadline = new Date(data.deadline);
            const formattedDeadline = deadline.toISOString().slice(0, 16);
            form.querySelector('[name="deadline"]').value = formattedDeadline;
            
            form.querySelector('[name="format"]').value = data.format;
            form.querySelector('[name="guidelines"]').value = data.guidelines;
            
            // Show modal
            document.getElementById('createModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching submission type:', error);
            alert('Failed to load submission type data');
        });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/admin/partials/submissionsType.blade.php ENDPATH**/ ?>