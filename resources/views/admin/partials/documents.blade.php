@extends('admin.layouts.admin')

@section('admin-content')
<div class="px-6 py-4 border-b border-gray-200 shadow-sm bg-white">
    <h2 class="text-2xl font-semibold text-gray-800 tracking-tight">Document Management</h2>
</div>

<div class="mt-6 px-6 py-4 bg-white rounded-lg shadow-md border border-gray-200">
        @if (session('success'))
            <div class="bg-green-100 border border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif
    <!-- Search and Filter Section -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0 md:space-x-4">
        <div class="w-full md:w-4/4">
            <input 
                type="text" 
                placeholder="Search documents..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
            >
        </div>
        <button class="w-full md:w-auto px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
            Search
        </button>
    </div>
    <!-- Mass Assign Section -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-4 md:space-y-0">
        <select id="mass-assign-reviewer" 
                class="w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            <option value="">Select Reviewer</option>
            @foreach ($reviewers as $reviewer)
                <option value="{{ $reviewer->reg_no }}">{{ $reviewer->name }}</option>
            @endforeach
        </select>
        <button id="mass-assign-btn" 
                class="w-full md:w-auto px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
            Assign to Selected
        </button>
    </div>

    <!-- Document Table -->
    <div class="overflow-x-auto h-80 overflow-y-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">
                        <input type="checkbox" id="select-all" class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Type</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Submitted By</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Submission Date</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Score</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Reviewer</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Related Documents</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            @foreach ($submissions as $submission)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">
                        <input type="checkbox" class="submission-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded" 
                            value="{{ $submission->serial_number }}">
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        <div class="font-medium">{{ $submission->title }}</div>
                        <div class="text-xs text-gray-500">{{ $submission->serial_number }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">Abstract</td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $submission->user_reg_no }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        @if(!$submission->score)
                            Not reviewed
                        @elseif($submission->score < 30)
                            <span class="text-orange-800 font-semibold">Need revision</span>
                        @else
                            {{ $submission->score }}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        @if($submission->reviewer_reg_no && $submission->reviewer_name)
                            @php
                                $firstName = explode(' ', $submission->reviewer_name)[0];
                            @endphp
                            <span>{{ $firstName }}</span>
                            <!-- Form for removing reviewer -->
                            <form action="{{ route('remove.abstract.reviewer', $submission->serial_number) }}" method="POST" class="inline">
                                @csrf
                                @method('POST')
                                <button type="submit" class="ml-2 text-red-500 hover:text-red-700" title="Remove Reviewer">
                                    X
                                </button>
                            </form>
                        @else
                            <span class="text-red-500">Not assigned</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @php
                            $statusStyles = [
                                'Pending' => [
                                    'text' => 'text-yellow-800',
                                    'bg' => 'bg-yellow-100'
                                ],
                                'Approved' => [
                                    'text' => 'text-green-800',
                                    'bg' => 'bg-green-100'
                                ],
                                'Under Review' => [
                                    'text' => 'text-blue-800',
                                    'bg' => 'bg-blue-100'
                                ],
                                'Rejected' => [
                                    'text' => 'text-red-800',
                                    'bg' => 'bg-red-100'
                                ],
                                'Needs Revision' => [
                                    'text' => 'text-orange-800',
                                    'bg' => 'bg-orange-100'
                                ]
                            ];
                            $currentStatus = $submission->final_status;
                            $style = $statusStyles[$currentStatus] ?? [
                                'text' => 'text-gray-800',
                                'bg' => 'bg-gray-100'
                            ];
                        @endphp
                        <span class="px-3 py-1 text-xs font-medium {{ $style['text'] }} {{ $style['bg'] }} rounded-full">
                            {{ $currentStatus ?: 'Unknown' }}
                        </span>
                    </td>                    
                    <td class="px-4 py-3 text-center">
                        @if($submission->final_status === 'Approved' && !$submission->article)
                            <form action="" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="inline-block px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full">
                                    Request Article Upload
                                </button>
                            </form>
                        @elseif($submission->article)
                            <a href="{{ route('article.view', $submission->article->id) }}" 
                            class="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                                View Article
                            </a>
                        @else
                            <span class="text-xs text-gray-500">No article submitted yet</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2 justify-center">
                            <div class="dropdown relative">
                                <button onclick="toggleDropdown('actions-dropdown-{{ $submission->serial_number }}')" 
                                        class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full">
                                    Actions ▼
                                </button>
                                <div id="actions-dropdown-{{ $submission->serial_number }}" 
                                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10">
                                    <div class="py-1">
                                        <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
                                                onclick="openModal('assign-reviewer-modal-{{ $submission->serial_number }}')">
                                                Assign Reviewer
                                        </button>
                                        <form action="{{ route('approve.abstract') }}" method="POST" class="contents">
                                            @csrf
                                            <input type="hidden" name="serial_number" value="{{ $submission->serial_number }}">
                                            <button type="submit" 
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Approve
                                            </button>
                                        </form>
                                        <a href="{{ route('research.abstract.download', $submission->serial_number) }}" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Download PDF
                                        </a>
                                        <a href="{{ route('abstract.abstractWord.download', $submission->serial_number) }}" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Download Word
                                        </a>
                                        <button class="block w-full text-left px-4 py-2 text-sm text-green-900 hover:bg-gray-100">
                                            Return for Revision
                                        </button>
                                        <button class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100" 
                                                onclick="openModal('add-comments-modal-{{ $submission->serial_number }}')">
                                            Reject
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Rejection Modal -->
                <div id="add-comments-modal-{{ $submission->serial_number }}" 
                    class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Add Comments for Rejecting</h3>
                        <form action="{{ route('reject.abstract') }}" method="POST">
                            @csrf
                            <input type="hidden" name="serial_number" value="{{ $submission->serial_number }}">
                            <textarea 
                                name="comments"
                                rows="4" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                                placeholder="Write your comments here..."
                                required></textarea>
                            <div class="mt-4 flex justify-end">
                                <button type="button" 
                                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-2" 
                                        onclick="closeModal('add-comments-modal-{{ $submission->serial_number }}')">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Reject
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                 <!-- Modal for Assigning Reviewer -->
                 <div id="assign-reviewer-modal-{{ $submission->serial_number }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Assign Reviewer</h3>
                        <form action="{{ route('assign.abstract.reviewer', $submission->serial_number) }}" method="POST">
                            @csrf
                            <select name="reg_no" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none mb-4" 
                                    required>
                                <option value="">Select Reviewer</option>
                                @foreach ($reviewers as $reviewer)
                                    <option value="{{ $reviewer->reg_no }}">{{ $reviewer->name }}</option>
                                @endforeach
                            </select>
                            <div class="mt-4 flex justify-end">
                                <button type="button" 
                                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-2" 
                                        onclick="closeModal('assign-reviewer-modal-{{ $submission->serial_number }}')">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Assign
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
            @foreach ($researchSubmissions as $researchSubmission)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">
                        <input type="checkbox" class="submission-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded" 
                            value="{{ $researchSubmission->serial_number }}">
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        <div class="font-medium">{{ $researchSubmission->article_title }}</div>
                        <div class="text-xs text-gray-500">{{ $researchSubmission->serial_number }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">Research Proposal</td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $researchSubmission->user_reg_no }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ \Carbon\Carbon::parse($researchSubmission->created_at)->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        @if(!$researchSubmission->score)
                            Not reviewed
                        @elseif($researchSubmission->score < 30)
                            Below Average
                        @else
                            {{ $researchSubmission->score }}
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        @if($researchSubmission->reviewer_reg_no && $researchSubmission->reviewer_name)
                            @php
                                $firstName = explode(' ', $researchSubmission->reviewer_name)[0];
                            @endphp
                            <span>{{ $firstName }}</span>
                            <!-- Form for removing reviewer -->
                            <form action="{{ route('remove.proposal.reviewer', $researchSubmission->serial_number) }}" method="POST" class="inline">
                                @csrf
                                @method('POST')
                                <button type="submit" class="ml-2 text-red-500 hover:text-red-700" title="Remove Reviewer">
                                    X
                                </button>
                            </form>
                        @else
                            <span class="text-red-500">Not assigned</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @php
                            $statusStyles = [
                                'Pending' => [
                                    'text' => 'text-yellow-800',
                                    'bg' => 'bg-yellow-100'
                                ],
                                'Approved' => [
                                    'text' => 'text-green-800',
                                    'bg' => 'bg-green-100'
                                ],
                                'Under Review' => [
                                    'text' => 'text-blue-800',
                                    'bg' => 'bg-blue-100'
                                ],
                                'Rejected' => [
                                    'text' => 'text-red-800',
                                    'bg' => 'bg-red-100'
                                ],
                                'Needs Revision' => [
                                    'text' => 'text-orange-800',
                                    'bg' => 'bg-orange-100'
                                ]
                            ];

                            $currentStatus = $researchSubmission->final_status;
                            $style = $statusStyles[$currentStatus] ?? [
                                'text' => 'text-gray-800',
                                'bg' => 'bg-gray-100'
                            ];
                        @endphp

                        <span class="px-3 py-1 text-xs font-medium {{ $style['text'] }} {{ $style['bg'] }} rounded-full">
                            {{ $currentStatus ?: 'Unknown' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <button class="text-xs text-blue-600 hover:underline">View Abstract</button>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2 justify-center">
                            <div class="dropdown relative">
                                <!-- Dropdown button -->
                                <button onclick="toggleDropdown('actions-dropdown-{{ $researchSubmission->serial_number }}')" 
                                        class="px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full">
                                    Actions ▼
                                </button>
                                <div id="actions-dropdown-{{ $researchSubmission->serial_number }}" 
                                    class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg z-10">
                                    <div class="py-1">
                                        <button 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            onclick="openModal('assign-reviewer-modal-{{ $researchSubmission->serial_number }}')">
                                            Assign Reviewer</button>
                                        <form action="{{ route('approve.proposal') }}" method="POST" class="contents">
                                            @csrf
                                            <input type="hidden" name="serial_number" value="{{ $researchSubmission->serial_number }}">
                                            <button type="submit" 
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Approve
                                            </button>
                                        </form>
                                        <a href="{{ route('proposal.abstract.download', $researchSubmission->serial_number) }}" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Download PDF
                                        </a>
                                        <a href="{{ route('proposal.abstractWord.download', $researchSubmission->serial_number) }}" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Download Word
                                        </a>
                                        <button class="block w-full text-left px-4 py-2 text-sm text-green-900 hover:bg-gray-100">Return for Revision</button>
                                        <button class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100"
                                                onclick="openModal('add-comments-modal-{{ $researchSubmission->serial_number }}')">
                                                Reject</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- Rejection Modal -->
                <div id="add-comments-modal-{{ $researchSubmission->serial_number }}" 
                    class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Add Comments for Rejecting</h3>
                        <form action="{{ route('reject.proposal') }}" method="POST">
                            @csrf
                            <input type="hidden" name="serial_number" value="{{ $researchSubmission->serial_number }}">
                            <textarea 
                                name="comments"
                                rows="4" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                                placeholder="Write your comments here..."
                                required></textarea>
                            <div class="mt-4 flex justify-end">
                                <button type="button" 
                                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-2" 
                                        onclick="closeModal('add-comments-modal-{{ $researchSubmission->serial_number }}')">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Reject
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
               <!-- Modal for Assigning Reviewer -->
               <div id="assign-reviewer-modal-{{ $researchSubmission->serial_number }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Assign Reviewer</h3>
                        <form action="{{ route('assign.proposal.reviewer', $researchSubmission->serial_number) }}" method="POST">
                            @csrf
                            <select name="reg_no" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none mb-4" 
                                    required>
                                <option value="">Select Reviewer</option>
                                @foreach ($reviewers as $reviewer)
                                    <option value="{{ $reviewer->reg_no }}">{{ $reviewer->name }}</option>
                                @endforeach
                            </select>
                            <div class="mt-4 flex justify-end">
                                <button type="button" 
                                        class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-2" 
                                        onclick="closeModal('assign-reviewer-modal-{{ $researchSubmission->serial_number }}')">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">
                                    Assign
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination 
    <div class="mt-6 flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Showing 1 to 10 of 50 entries
        </div>
        <div class="flex space-x-2">
            <button class="px-3 py-1 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Previous</button>
            <button class="px-3 py-1 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">1</button>
            <button class="px-3 py-1 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">2</button>
            <button class="px-3 py-1 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">3</button>
            <button class="px-3 py-1 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Next</button>
        </div>
    </div>
</div>-->
<script>
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }
    
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const allDropdowns = document.querySelectorAll('.dropdown div[id^="actions-dropdown-"]');
        
        // Close all other dropdowns
        allDropdowns.forEach(d => {
            if (d.id !== dropdownId) {
                d.classList.add('hidden');
            }
        });
        
        // Toggle the clicked dropdown
        dropdown.classList.toggle('hidden');
    }
    
    // Close dropdowns when clicking outside
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            const allDropdowns = document.querySelectorAll('.dropdown div[id^="actions-dropdown-"]');
            allDropdowns.forEach(d => d.classList.add('hidden'));
        }
    });
</script>
<script>
    // Select/Deselect All Checkboxes
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.submission-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Handle Mass Assign Button Click
    document.getElementById('mass-assign-btn').addEventListener('click', function() {
        const selectedSubmissions = Array.from(document.querySelectorAll('.submission-checkbox:checked'))
            .map(checkbox => checkbox.value);
        const selectedReviewer = document.getElementById('mass-assign-reviewer').value;

        if (selectedSubmissions.length === 0 || !selectedReviewer) {
            alert('Please select at least one submission and a reviewer.');
            return;
        }

        // Send data to the server
        fetch('{{ route('assign.mass.reviewer') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                submissions: selectedSubmissions,
                reviewer: selectedReviewer
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Reload page to reflect changes
        })
        .catch(error => console.error('Error:', error));
    });
</script>
<script>
    // Select/Deselect All Checkboxes
    document.getElementById('select-all-proposal').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.submission-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Handle Mass Assign Button Click
    document.getElementById('mass-assign-btn').addEventListener('click', function() {
        const selectedSubmissions = Array.from(document.querySelectorAll('.submission-checkbox:checked'))
            .map(checkbox => checkbox.value);
        const selectedReviewer = document.getElementById('mass-assign-reviewer').value;

        if (selectedSubmissions.length === 0 || !selectedReviewer) {
            alert('Please select at least one submission and a reviewer.');
            return;
        }

        // Send data to the server
        fetch('{{ route('assign.mass.reviewer') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                submissions: selectedSubmissions,
                reviewer: selectedReviewer
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Reload page to reflect changes
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection