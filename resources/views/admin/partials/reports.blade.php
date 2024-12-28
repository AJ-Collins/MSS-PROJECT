@extends('admin.layouts.admin')

@section('admin-content')
<div class="container mx-auto p-6 space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Reports & Analytics</h1>
        <a href="{{ route('abstract.downloadAll') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            Download All Abstracts PDF
        </a>
        <a href="{{ route('abstracts.download.word') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            Download All Abstracts Words
        </a>
        <a href="{{ route('proposal.downloadAll') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            Download All Proposals PDF
        </a>
        <a href="{{ route('proposal.downloadAllWord') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            Download All Proposals Word
        </a>
    </div>

    <!-- Analytics Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Total Documents</h2>
            <p class="text-4xl font-bold text-indigo-600">120</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Reviewed Documents</h2>
            <p class="text-4xl font-bold text-green-600">90</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Pending Documents</h2>
            <p class="text-4xl font-bold text-yellow-600">30</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="mt-6 bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Document Reports</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Document Name</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Uploaded By</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Uploaded On</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 border-b">Marks Awarded</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Row -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">Document1.pdf</td>
                        <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-500">2024-12-15</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Approved</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">85/100</td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('view-report-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    View Report
                                </button>
                                <button onclick="openModal('generate-report-modal')" class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Generate Report
                                </button>
                                <button onclick="openModal('view-analytics-modal')" class="px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-lg">
                                    View Analytics
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">Document1.pdf</td>
                        <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-500">2024-12-15</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Approved</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">85/100</td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('view-report-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    View Report
                                </button>
                                <button onclick="openModal('generate-report-modal')" class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Generate Report
                                </button>
                                <button onclick="openModal('view-analytics-modal')" class="px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-lg">
                                    View Analytics
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">Document1.pdf</td>
                        <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-500">2024-12-15</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Approved</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">85/100</td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('view-report-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    View Report
                                </button>
                                <button onclick="openModal('generate-report-modal')" class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Generate Report
                                </button>
                                <button onclick="openModal('view-analytics-modal')" class="px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-lg">
                                    View Analytics
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">Document1.pdf</td>
                        <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                        <td class="px-4 py-3 text-sm text-gray-500">2024-12-15</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Approved</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">85/100</td>
                        <td class="px-4 py-3 text-center text-sm">
                            <div class="flex justify-center gap-2">
                                <button onclick="openModal('view-report-modal')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                                    View Report
                                </button>
                                <button onclick="openModal('generate-report-modal')" class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Generate Report
                                </button>
                                <button onclick="openModal('view-analytics-modal')" class="px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-lg">
                                    View Analytics
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
    <!-- View Report Modal -->
    <div id="view-report-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Report Details for Document1.pdf</h3>
            <p class="text-sm text-gray-600 mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <button onclick="closeModal('view-report-modal')" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Close</button>
        </div>
    </div>

    <!-- Generate Report Modal -->
    <div id="generate-report-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Generate Report for Document1.pdf</h3>
            <p class="text-sm text-gray-600 mb-4">Click the button below to generate the report.</p>
            <button onclick="closeModal('generate-report-modal')" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Generate</button>
        </div>
    </div>

    <!-- View Analytics Modal -->
    <div id="view-analytics-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Analytics for Document1.pdf</h3>
            <p class="text-sm text-gray-600 mb-4">Detailed analytics about this document will be displayed here.</p>
            <button onclick="closeModal('view-analytics-modal')" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Close</button>
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
</div>
@endsection
