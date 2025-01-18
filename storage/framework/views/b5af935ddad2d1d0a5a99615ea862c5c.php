

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6 space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Manage Submissions</h1>
        
        <div class="flex items-center gap-4">
            <input type="text" placeholder="Search submissions..." class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <select class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm">
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
            <button class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Filter
            </button>
        </div>
    </div>

    <!-- Submissions Table -->
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Submissions</h2>
        <p class=""><strong>Note:</strong>The documents listed here are intended for final review and disposition.</p>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Submission ID</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Submitted By</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Submitted On</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Status</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Submission -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">#12345</td>
                        <td class="px-4 py-3 text-sm text-gray-700">Jane Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-500">2024-12-19</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('view-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    View
                                </button>
                                <button onclick="openModal('approve-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg">
                                    Approve
                                </button>
                                <button class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-full">Final Disposition</button>
                                <button onclick="openModal('reject-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">#12345</td>
                        <td class="px-4 py-3 text-sm text-gray-700">Jane Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-500">2024-12-19</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('view-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    View
                                </button>
                                <button onclick="openModal('approve-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg">
                                    Approve
                                </button>
                                <button class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-full">Final Disposition</button>
                                <button onclick="openModal('reject-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">#12345</td>
                        <td class="px-4 py-3 text-sm text-gray-700">Jane Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-500">2024-12-19</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('view-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    View
                                </button>
                                <button onclick="openModal('approve-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg">
                                    Approve
                                </button>
                                <button class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-full">Final Disposition</button>
                                <button onclick="openModal('reject-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">#12345</td>
                        <td class="px-4 py-3 text-sm text-gray-700">Jane Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-500">2024-12-19</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('view-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    View
                                </button>
                                <button onclick="openModal('approve-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg">
                                    Approve
                                </button>
                                <button class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-full">Final Disposition</button>
                                <button onclick="openModal('reject-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">#12345</td>
                        <td class="px-4 py-3 text-sm text-gray-700">Jane Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-500">2024-12-19</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Pending</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('view-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    View
                                </button>
                                <button onclick="openModal('approve-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg">
                                    Approve
                                </button>
                                <button class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-full">Final Disposition</button>
                                <button onclick="openModal('reject-submission-modal')" class="px-3 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                                    Reject
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
    <!-- View Submission Modal -->
    <div id="view-submission-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Submission Details</h3>
            <p class="text-sm text-gray-600 mb-4">Details of the submission will be displayed here.</p>
            <button onclick="closeModal('view-submission-modal')" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Close</button>
        </div>
    </div>

    <!-- Approve Submission Modal -->
    <div id="approve-submission-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Approve Submission</h3>
            <p class="text-sm text-gray-600 mb-4">Are you sure you want to approve this submission?</p>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Approve</button>
            <button onclick="closeModal('approve-submission-modal')" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Cancel</button>
        </div>
    </div>

    <!-- Reject Submission Modal -->
    <div id="reject-submission-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Reject Submission</h3>
            <p class="text-sm text-gray-600 mb-4">Please provide a reason for rejection.</p>
            <textarea class="w-full border border-gray-300 rounded-lg shadow-sm p-2" rows="4" placeholder="Enter rejection reason..."></textarea>
            <button type="submit" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Reject</button>
            <button onclick="closeModal('reject-submission-modal')" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Cancel</button>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views\admin\partials\submissions.blade.php ENDPATH**/ ?>