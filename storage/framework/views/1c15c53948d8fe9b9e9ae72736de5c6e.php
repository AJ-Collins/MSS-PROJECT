

<?php $__env->startSection('admin-content'); ?>
<div class="container mx-auto p-4 space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">User Management</h1>
        <button onclick="openModal('create-user-modal')" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            Create User
        </button>
    </div>

    <!-- User Table -->
    <div class="mt-6 bg-white p-3 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Manage Users</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Name</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Role</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Status</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example User -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-700">john.doe@example.com</td>
                        <td class="px-4 py-3 text-sm text-gray-700">Admin</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('edit-user-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    Edit
                                </button>
                                <button onclick="openModal('assign-role-modal')" class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Assign Role
                                </button>
                                <button onclick="openModal('deactivate-user-modal')" class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                                    Deactivate
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-700">john.doe@example.com</td>
                        <td class="px-4 py-3 text-sm text-gray-700">Admin</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('edit-user-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    Edit
                                </button>
                                <button onclick="openModal('assign-role-modal')" class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Assign Role
                                </button>
                                <button onclick="openModal('deactivate-user-modal')" class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                                    Deactivate
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-700">john.doe@example.com</td>
                        <td class="px-4 py-3 text-sm text-gray-700">Admin</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('edit-user-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    Edit
                                </button>
                                <button onclick="openModal('assign-role-modal')" class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Assign Role
                                </button>
                                <button onclick="openModal('deactivate-user-modal')" class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                                    Deactivate
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-700">john.doe@example.com</td>
                        <td class="px-4 py-3 text-sm text-gray-700">Admin</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Active</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('edit-user-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    Edit
                                </button>
                                <button onclick="openModal('assign-role-modal')" class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Assign Role
                                </button>
                                <button onclick="openModal('deactivate-user-modal')" class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                                    Deactivate
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Additional rows can be dynamically rendered here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modals -->
    <!-- Create User Modal -->
    <div id="create-user-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Create User</h3>
            <form>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" placeholder="Enter user name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" placeholder="Enter user email" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2">
                            <option>Admin</option>
                            <option>Editor</option>
                            <option>Viewer</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="mt-6 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Create</button>
            </form>
            <button onclick="closeModal('create-user-modal')" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Cancel</button>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="edit-user-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Edit User</h3>
            <form>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" value="John Doe" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" value="john.doe@example.com" required>
                    </div>
                </div>
                <button type="submit" class="mt-6 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Save Changes</button>
            </form>
            <button onclick="closeModal('edit-user-modal')" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Cancel</button>
        </div>
    </div>

    <!-- Assign Role Modal -->
    <div id="assign-role-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Assign Role to User</h3>
            <form>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <select class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2">
                        <option>Admin</option>
                        <option>Editor</option>
                        <option>Viewer</option>
                    </select>
                </div>
                <button type="submit" class="mt-6 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Assign Role</button>
            </form>
            <button onclick="closeModal('assign-role-modal')" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Cancel</button>
        </div>
    </div>

    <!-- Deactivate User Modal -->
    <div id="deactivate-user-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Deactivate User</h3>
            <p class="text-sm text-gray-600 mb-4">Are you sure you want to deactivate this user? This action can be reversed later.</p>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Deactivate</button>
            <button onclick="closeModal('deactivate-user-modal')" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Cancel</button>
        </div>
    </div>

    <!-- JavaScript for Modal Management -->
    <script>
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
    </script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views\reviewer\partials\users.blade.php ENDPATH**/ ?>