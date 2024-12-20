@extends('admin.layouts.admin')

@section('admin-content')
<div class="px-6 py-4 border-b border-gray-200 shadow-sm bg-white">
    <h2 class="text-2xl font-semibold text-gray-800 tracking-tight">Manage Documents</h2>
</div>

<div class="mt-6 px-6 py-4 bg-white rounded-lg shadow-md border border-gray-200">
    <!-- Search Functionality -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
        <input 
            type="text" 
            placeholder="Search documents..." 
            class="w-full md:w-2/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
        >
        <button class="w-full md:w-auto px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
            Search
        </button>
    </div>

    <!-- Document Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Document Name</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Uploaded By</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Uploaded On</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example Row -->
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-700">Document1.pdf</td>
                    <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                    <td class="px-4 py-3 text-sm text-gray-500">2024-12-20</td>
                    <td class="px-4 py-3 text-center text-sm">
                        <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Under Review</span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm">
                        <!-- Actions arranged in a flex column for responsiveness -->
                        <div class="flex flex-wrap gap-2 justify-center">
                            <button class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">Assign Reviewer</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-full">Return for Revision</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full" onclick="openModal('add-comments-modal')">Add Comments</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">Show Remarks</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">Download</button>
                    </td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-700">Document1.pdf</td>
                    <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                    <td class="px-4 py-3 text-sm text-gray-500">2024-12-20</td>
                    <td class="px-4 py-3 text-center text-sm">
                        <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Under Review</span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm">
                        <!-- Actions arranged in a flex column for responsiveness -->
                        <div class="flex flex-wrap gap-2 justify-center">
                            <button class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">Assign Reviewer</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-full">Return for Revision</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full" onclick="openModal('add-comments-modal')">Add Comments</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">Show Remarks</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">Download</button>
                        </div>
                    </td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-700">Document1.pdf</td>
                    <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                    <td class="px-4 py-3 text-sm text-gray-500">2024-12-20</td>
                    <td class="px-4 py-3 text-center text-sm">
                        <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Under Review</span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm">
                        <!-- Actions arranged in a flex column for responsiveness -->
                        <div class="flex flex-wrap gap-2 justify-center">
                            <button class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">Assign Reviewer</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-full">Return for Revision</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full" onclick="openModal('add-comments-modal')">Add Comments</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">Show Remarks</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">Download</button>
                    </td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-700">Document1.pdf</td>
                    <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                    <td class="px-4 py-3 text-sm text-gray-500">2024-12-20</td>
                    <td class="px-4 py-3 text-center text-sm">
                        <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Under Review</span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm">
                        <!-- Actions arranged in a flex column for responsiveness -->
                        <div class="flex flex-wrap gap-2 justify-center">
                            <button class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">Assign Reviewer</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-full">Return for Revision</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full" onclick="openModal('add-comments-modal')">Add Comments</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">Show Remarks</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">Download</button>
                        </div>
                    </td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-700">Document1.pdf</td>
                    <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                    <td class="px-4 py-3 text-sm text-gray-500">2024-12-20</td>
                    <td class="px-4 py-3 text-center text-sm">
                        <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Under Review</span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm">
                        <!-- Actions arranged in a flex column for responsiveness -->
                        <div class="flex flex-wrap gap-2 justify-center">
                            <button class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">Assign Reviewer</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-full">Return for Revision</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full" onclick="openModal('add-comments-modal')">Add Comments</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">Show Remarks</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">Download</button>
                        </div>
                    </td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-700">Document1.pdf</td>
                    <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                    <td class="px-4 py-3 text-sm text-gray-500">2024-12-20</td>
                    <td class="px-4 py-3 text-center text-sm">
                        <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Under Review</span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm">
                        <!-- Actions arranged in a flex column for responsiveness -->
                        <div class="flex flex-wrap gap-2 justify-center">
                            <button class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">Assign Reviewer</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-full">Return for Revision</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full" onclick="openModal('add-comments-modal')">Add Comments</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">Show Remarks</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">Download</button>
                        </div>
                    </td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-700">Document1.pdf</td>
                    <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                    <td class="px-4 py-3 text-sm text-gray-500">2024-12-20</td>
                    <td class="px-4 py-3 text-center text-sm">
                        <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Under Review</span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm">
                        <!-- Actions arranged in a flex column for responsiveness -->
                        <div class="flex flex-wrap gap-2 justify-center">
                            <button class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">Assign Reviewer</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-full">Return for Revision</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full" onclick="openModal('add-comments-modal')">Add Comments</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">Show Remarks</button>
                            <button class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">Download</button>
                        </div>
                    </td>
                </tr>
                
                <!-- Additional rows can be dynamically rendered here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Adding Review Comments -->
<div id="add-comments-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
        <h3 class="text-lg font-medium text-gray-800 mb-4">Add Review Comments</h3>
        <textarea 
            rows="4" 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
            placeholder="Write your comments here..."></textarea>
        <div class="mt-4 flex justify-end">
            <button class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-2" onclick="closeModal('add-comments-modal')">Cancel</button>
            <button class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">Submit</button>
        </div>
    </div>
</div>

<script>
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }
</script>
@endsection
