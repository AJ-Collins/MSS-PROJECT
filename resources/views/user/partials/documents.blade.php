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
                    @foreach ($submissions as $submission)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $submission->title }}</div>
                                <div class="text-sm text-gray-500">{{ $submission->sub_theme }}</div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-center">
                                @php
                                    $AbstractStatus = [
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Approved' => 'bg-green-100 text-green-800',
                                        'Rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $AbstractStatus = $AbstractStatus[$submission->final_status ?? 'Pending'] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $AbstractStatus }}">
                                    {{ $submission->final_status ?? 'Pending' }}
                                </span>        
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-col items-center space-y-2">
                                    <button onclick="openModal('abstract-preview-modal-{{ $submission->serial_number }}')" class="text-xs text-blue-600 hover:text-blue-800">View Abstract</button>
                                    <button onclick="openModal('proposal-preview-modal-{{ $submission->serial_number }}')" class="text-xs text-blue-600 hover:text-blue-800">View Article</button>
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
                            <!-- Abstract Preview Modal -->
                            <div id="abstract-preview-modal-{{ $submission->serial_number }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white shadow-xl w-full max-w-4xl flex flex-col" style="height: 95vh;">
                                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                        <h3 class="text-lg font-medium text-gray-800">Abstract Preview</h3>
                                        <button onclick="closeModal('abstract-preview-modal-{{ $submission->serial_number }}')" class="text-gray-400 hover:text-gray-500">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex-1 p-6 overflow-auto">
                                        <div class="space-y-4">
                                            <h4 class="text-lg font-medium">{{ $submission->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $submission->sub_theme }}</p>
                                            
                                            <div class="mt-4">
                                                <p class="text-sm text-gray-700"><strong>Status:</strong>
                                                    <span class="text-sm {{ $AbstractStatus }}">
                                                        {{ $submission->final_status ?? 'Pending' }}
                                                    </span>
                                                </p>
                                                <p class="text-sm text-gray-700"><strong>Submission Date:</strong> 
                                                    {{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y') }}
                                                </p>
                                                
                                                @if($submission->abstract)
                                                    <div class="mt-4">
                                                        <h5 class="font-medium">Abstract</h5>
                                                        <p class="text-sm text-gray-700">{{ $submission->abstract }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                                        <button onclick="closeModal('abstract-preview-modal-{{ $submission->serial_number }}')" 
                                                class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Proposal Preview Modal -->
                            <div id="proposal-preview-modal-{{ $submission->serial_number }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white shadow-xl w-full max-w-4xl flex flex-col" style="height: 95vh;">
                                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                        <h3 class="text-lg font-medium text-gray-800">Proposal Preview</h3>
                                        <button onclick="closeModal('proposal-preview-modal-{{ $submission->serial_number }}')" class="text-gray-400 hover:text-gray-500">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex-1 p-6 overflow-auto">
                                        @if($submission->pdf_document_path)
                                            <iframe 
                                                src="{{ asset('/' . $submission->pdf_document_path) }}" 
                                                class="w-full h-full border-0"
                                                type="application/pdf"
                                            >
                                                <p>Your browser doesn't support PDF viewing. Please 
                                                    <a href="{{ asset('/' . $submission->pdf_document_path) }}" target="_blank">click here to view the PDF</a>.
                                                </p>
                                            </iframe>
                                        @else
                                            <div class="flex items-center justify-center h-full">
                                                <p class="text-gray-500">No article document available</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                                        <button 
                                            onclick="closeModal('proposal-preview-modal-{{ $submission->serial_number }}')" 
                                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg"
                                        >
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach 
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
                    @foreach ($researchSubmissions as $researchSubmission)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $researchSubmission->article_title }}</div>
                                <div class="text-sm text-gray-500">{{ $researchSubmission->sub_theme }}</div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($researchSubmission->created_at)->format('d M Y') }}</td>
                            <td class="px-4 py-4 text-center">
                                @php
                                    $AbstractStatus = [
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Approved' => 'bg-green-100 text-green-800',
                                        'Rejected' => 'bg-red-100 text-red-800',
                                    ];
                                    $AbstractStatus = $AbstractStatus[$researchSubmission->final_status ?? 'Pending'] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $AbstractStatus }}">
                                    {{ $researchSubmission->final_status ?? 'Pending' }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex flex-col items-center space-y-2">
                                    <button onclick="openModal('abstract-preview-modal-{{ $researchSubmission->serial_number }}')" class="text-xs text-blue-600 hover:text-blue-800">View Abstract</button>
                                    <button onclick="openModal('proposal-preview-modal-{{ $researchSubmission->serial_number }}')" class="text-xs text-blue-600 hover:text-blue-800">View Proposal</button>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-center space-x-2">
                                    <button onclick="openModal('reviewer-remarks-modal-{{ $researchSubmission->id }}')" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">
                                        Reviewer Remarks
                                    </button>
                                    <button onclick="openModal('admin-remarks-modal-{{ $researchSubmission->id }}')" class="px-3 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">
                                        Admin Remarks
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Abstract Preview Modal -->
                        <div id="abstract-preview-modal-{{ $researchSubmission->serial_number }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white shadow-xl w-full max-w-4xl flex flex-col" style="height: 95vh;">
                                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-800">Abstract Preview</h3>
                                    <button onclick="closeModal('abstract-preview-modal-{{ $researchSubmission->serial_number }}')" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex-1 p-6 overflow-auto">
                                    <div class="space-y-4">
                                        <h4 class="text-lg font-medium">{{ $researchSubmission->article_title }}</h4>
                                        <p class="text-sm text-gray-600">{{ $researchSubmission->sub_theme }}</p>
                                        
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-700"><strong>Status:</strong>
                                                <span class="text-sm {{ $AbstractStatus }}">
                                                    {{ $researchSubmission->final_status ?? 'Pending' }}
                                                </span>
                                            </p>
                                            <p class="text-sm text-gray-700"><strong>Submission Date:</strong> 
                                                {{ \Carbon\Carbon::parse($researchSubmission->created_at)->format('d M Y') }}
                                            </p>
                                            
                                            @if($researchSubmission->abstract)
                                                <div class="mt-4">
                                                    <h5 class="font-medium">Abstract</h5>
                                                    <p class="text-sm text-gray-700">{{ $researchSubmission->abstract }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                                    <button onclick="closeModal('abstract-preview-modal-{{ $researchSubmission->serial_number }}')" 
                                            class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Proposal Preview Modal -->
                        <div id="proposal-preview-modal-{{ $researchSubmission->serial_number }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white shadow-xl w-full max-w-4xl flex flex-col" style="height: 95vh;">
                                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-800">Proposal Preview</h3>
                                    <button onclick="closeModal('proposal-preview-modal-{{ $researchSubmission->serial_number }}')" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex-1 p-6 overflow-auto">
                                    @if($researchSubmission->pdf_document_path)
                                        <iframe 
                                            src="{{ asset('/' . $researchSubmission->pdf_document_path) }}" 
                                            class="w-full h-full border-0"
                                            type="application/pdf"
                                        >
                                            <p>Your browser doesn't support PDF viewing. Please 
                                                <a href="{{ asset('/' . $researchSubmission->pdf_document_path) }}" target="_blank">click here to view the PDF</a>.
                                            </p>
                                        </iframe>
                                    @else
                                        <div class="flex items-center justify-center h-full">
                                            <p class="text-gray-500">No proposal document available</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
                                    <button 
                                        onclick="closeModal('proposal-preview-modal-{{ $researchSubmission->serial_number }}')" 
                                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg"
                                    >
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Document Preview Modal -->
<div id="reviewer-remarks-2" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl h-[80vh] flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-800">Document Preview</h3>
            <button onclick="closeModal('reviewer-remarks-2')" class="text-gray-400 hover:text-gray-500">
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
    document.getElementById(modalId).classList.remove('hidden');
}
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}
</script>
@endsection