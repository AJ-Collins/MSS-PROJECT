@extends('user.layouts.user')

@section('user-content')
<div class="px-6 py-4 border-b border-gray-200 shadow-sm bg-white">
    <h2 class="text-2xl font-semibold text-gray-800 tracking-tight">My Submissions</h2>
</div>

<div class="container mx-auto px-6 py-8">
    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 md:space-x-4">
            <div class="w-full md:w-1/3">
                <input type="text" 
                    placeholder="Search submissions..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                >
            </div>
            <div class="w-full md:w-1/3">
                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none">
                    <option value="">All Types</option>
                    <option value="article">Articles</option>
                    <option value="research">Research Proposals</option>
                </select>
            </div>
            <button class="w-full md:w-auto px-6 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">
                Search
            </button>
        </div>
    </div>

    <!-- Articles Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Articles</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submission Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Documents</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <div class="text-sm font-medium text-gray-900">Impact of Climate Change</div>
                                <div class="text-sm text-gray-500">Environmental Science</div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500">Dec 20, 2024</td>
                            <td class="px-4 py-4 text-center">
                                <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Under Review</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-col items-center space-y-2">
                                    <button onclick="openDocumentPreview('abstract-1')" class="text-xs text-blue-600 hover:text-blue-800">View Abstract</button>
                                    <button onclick="openDocumentPreview('article-1')" class="text-xs text-blue-600 hover:text-blue-800">View Article</button>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-center space-x-2">
                                    <button onclick="openModal('reviewer-remarks-1')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">
                                        Reviewer Remarks
                                    </button>
                                    <button onclick="openModal('admin-remarks-1')" class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">
                                        Admin Remarks
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Research Proposals Section -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Research Proposals</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submission Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Documents</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <div class="text-sm font-medium text-gray-900">AI in Healthcare</div>
                                <div class="text-sm text-gray-500">Computer Science</div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500">Dec 15, 2024</td>
                            <td class="px-4 py-4 text-center">
                                <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Approved</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-col items-center space-y-2">
                                    <button onclick="openDocumentPreview('abstract-2')" class="text-xs text-blue-600 hover:text-blue-800">View Abstract</button>
                                    <button onclick="openDocumentPreview('proposal-1')" class="text-xs text-blue-600 hover:text-blue-800">View Proposal</button>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-center space-x-2">
                                    <button onclick="openModal('reviewer-remarks-2')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">
                                        Reviewer Remarks
                                    </button>
                                    <button onclick="openModal('admin-remarks-2')" class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">
                                        Admin Remarks
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Document Preview Modal -->
<div id="document-preview-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl h-[80vh] flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-800">Document Preview</h3>
            <button onclick="closeModal('document-preview-modal')" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="flex-1 p-6 overflow-auto">
            <div id="document-content" class="h-full">
                <!-- Document content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Remarks Modal -->
<div id="remarks-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 id="remarks-title" class="text-lg font-medium text-gray-800">Remarks</h3>
            <button onclick="closeModal('remarks-modal')" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <div id="remarks-content" class="prose max-w-none">
                <!-- Remarks content will be loaded here -->
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
            <button onclick="closeModal('remarks-modal')" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    if (modalId.startsWith('reviewer-remarks')) {
        document.getElementById('remarks-title').textContent = 'Reviewer Remarks';
        // Load reviewer remarks content
        document.getElementById('remarks-content').innerHTML = `
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="font-medium text-gray-700 mb-2">Reviewer #1</div>
                    <p class="text-gray-600">Detailed feedback would be loaded here...</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="font-medium text-gray-700 mb-2">Reviewer #2</div>
                    <p class="text-gray-600">Additional reviewer feedback...</p>
                </div>
            </div>
        `;
    } else if (modalId.startsWith('admin-remarks')) {
        document.getElementById('remarks-title').textContent = 'Admin Remarks';
        // Load admin remarks content
        document.getElementById('remarks-content').innerHTML = `
            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="font-medium text-gray-700 mb-2">Administrative Notes</div>
                <p class="text-gray-600">Admin feedback and status updates would be shown here...</p>
            </div>
        `;
    }
    document.getElementById('remarks-modal').classList.remove('hidden');
}

function openDocumentPreview(documentId) {
    // Load document content based on documentId
    document.getElementById('document-preview-modal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}
</script>
@endsection