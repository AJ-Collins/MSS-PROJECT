@extends('admin.layouts.admin')

@section('admin-content')
<div class="px-6 py-4 border-b border-gray-200 shadow-sm bg-white">
    <h2 class="text-2xl font-semibold text-gray-800 tracking-tight">Document Management</h2>
</div>
<div x-data="{ activeTab: 'abstracts' }">
    <!-- Tabbed Menu -->
    <div class="bg-white border-b border-gray-200">
        <div class="flex">
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'abstracts', 'border-transparent': activeTab !== 'abstracts' }"
                @click="activeTab = 'abstracts'">
                Abstracts
            </button>
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'proposals', 'border-transparent': activeTab !== 'proposals' }"
                @click="activeTab = 'proposals'">
                Research Proposals
            </button>
        </div>
    </div>

    <!-- Abstracts Tab Content -->
    <div x-show="activeTab === 'abstracts'">
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
        <div class="flex justify-between items-center mb-4">
            <!-- Bulk Selection -->
            <div class="flex items-center space-x-2">
                <input type="checkbox" id="select-all-abstracts" 
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded"
                    onclick="toggleSelectAllAbstracts(this)">
                <label for="select-all-abstracts" class="text-sm text-gray-700">Select All</label>
            </div>

            <!-- Reviewer Selection and Assign Button -->
            <div class="flex items-center space-x-4">
                <select id="reviewer-dropdown" 
                        name="reviewer" 
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        required>
                    <option value="">Select Reviewer</option>
                    @foreach ($reviewers as $reviewer)
                        <option value="{{ $reviewer->reg_no }}">{{ $reviewer->name }}</option>
                    @endforeach
                </select>
                <button onclick="assignAbstractReviewers()" 
                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                    Assign Reviewer
                </button>
            </div>
        </div>
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th><input type="checkbox" class="abstract-submission-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded"></th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>                 
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Submitted By</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Submission Date</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Score</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Reviewer</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Related Documents</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($submissions as $submission)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">
                        <input type="checkbox" class="abstract-submission-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded" 
                            value="{{ $submission->serial_number }}">
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        <div class="font-medium">{{ $submission->title }}</div>
                        <div class="text-xs text-gray-500">{{ $submission->serial_number }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $submission->user_reg_no }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        @if(!$submission->score)
                            <span class="text-gray-500">Not reviewed</span>
                        @else
                            <div class="flex items-center space-x-2">
                                <span class="font-medium">{{ $submission->score }}</span>
                                <button type="button" 
                                        data-submission-id="{{ $submission->serial_number }}"
                                        class="reject-score-btn p-1.5 rounded-full text-red-600 hover:text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition-all duration-200 relative group"
                                        aria-label="Reject Score">
                                    <svg xmlns="http://www.w3.org/2000/svg" 
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24" 
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span class="sr-only">Reject assessment</span>
                                    
                                    <!-- Enhanced Tooltip -->
                                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block z-20">
                                        <div class="bg-gray-900 text-white text-xs rounded px-2 py-1.5 whitespace-nowrap shadow-lg relative">
                                            Reject assessment
                                            <div class="absolute w-2 h-2 bg-gray-900 rotate-45 -bottom-1 left-1/2 -translate-x-1/2"></div>
                                        </div>
                                    </div>
                                </button>
                            </div>
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
                    <td class="px-4 py-3 text-center relative group">
                        @php
                            $statusStyles = [
                                'submitted' => [
                                    'text' => 'text-yellow-800',
                                    'bg' => 'bg-yellow-100',
                                    'icon' => '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"/></svg>'
                                ],
                                'under_review' => [
                                    'text' => 'text-blue-800',
                                    'bg' => 'bg-blue-100',
                                    'icon' => '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>'
                                ],
                                'rejected' => [
                                    'text' => 'text-red-800',
                                    'bg' => 'bg-red-100',
                                    'icon' => '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>'
                                ],
                                'revision_required' => [
                                    'text' => 'text-orange-800',
                                    'bg' => 'bg-orange-100',
                                    'icon' => '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/></svg>'
                                ],
                                'accepted' => [
                                    'text' => 'text-green-800',
                                    'bg' => 'bg-green-100',
                                    'icon' => '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>'
                                ]
                            ];
                            $currentStatus = $submission->final_status;
                            $style = $statusStyles[$currentStatus] ?? [
                                'text' => 'text-gray-800',
                                'bg' => 'bg-gray-100',
                                'icon' => '<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>'
                            ];
                        @endphp
                        <div class="flex items-center justify-center space-x-2">
                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium {{ $style['text'] }} {{ $style['bg'] }} rounded-full">
                                {!! $style['icon'] !!}
                                <span>{{ $currentStatus === 'revision_required' ? 'Revision Request' : str_replace('_', ' ', ucfirst($currentStatus ?: 'Unknown')) }}</span>
                            </span>
                            
                            @if($currentStatus === 'revision_required')
                                <div class="inline-flex items-center space-x-1 relative group">
                                    <form action="{{ route('accept.abstract.revision', ['serial_number' => $submission->serial_number]) }}" 
                                        method="POST" 
                                        class="inline-block">
                                        @csrf
                                        <button type="submit" 
                                                class="p-1 rounded-full text-green-600 hover:text-white hover:bg-green-600 focus:outline-none focus:ring-1 focus:ring-green-500 focus:ring-offset-1 transition-all duration-150"
                                                title="Accept Revision"
                                                aria-label="Accept Revision"
                                                onclick="return confirm('Are you sure you want to accept this revision?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" 
                                                class="h-4 w-4" 
                                                viewBox="0 0 20 20" 
                                                fill="currentColor">
                                                <path fill-rule="evenodd" 
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" 
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="sr-only">Accept</span>
                                        </button>
                                        
                                        <div class="absolute bottom-full left-0 mb-1 hidden group-hover:block z-10">
                                            <div class="bg-gray-800 text-white text-xs rounded px-2 py-0.5 whitespace-nowrap">
                                                Accept revision
                                            </div>
                                        </div>
                                    </form>

                                    <form action="{{ route('reject.abstract.revision', ['serial_number' => $submission->serial_number]) }}" 
                                        method="POST" 
                                        class="inline-block">
                                        @csrf
                                        <button type="submit" 
                                                class="p-1 rounded-full text-red-600 hover:text-white hover:bg-red-600 focus:outline-none focus:ring-1 focus:ring-red-500 focus:ring-offset-1 transition-all duration-150"
                                                title="Reject Revision"
                                                aria-label="Reject Revision"
                                                onclick="return confirm('Are you sure you want to reject this revision?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" 
                                                class="h-4 w-4" 
                                                viewBox="0 0 20 20" 
                                                fill="currentColor">
                                                <path fill-rule="evenodd" 
                                                    d="M6.293 4.293a1 1 0 011.414 0L10 6.586l2.293-2.293a1 1 0 111.414 1.414L11.414 8l2.293 2.293a1 1 0 11-1.414 1.414L10 9.414l-2.293 2.293a1 1 0 11-1.414-1.414L8.586 8 6.293 5.707a1 1 0 010-1.414z" 
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="sr-only">Reject</span>
                                        </button>
                                        
                                        <div class="absolute bottom-full right-0 mb-1 hidden group-hover:block z-10">
                                            <div class="bg-gray-800 text-white text-xs rounded px-2 py-0.5 whitespace-nowrap">
                                                Reject revision
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </td>                   
                    <td class="px-4 py-3 text-center relative" x-data="{ isOpen: false }">
                        @if($submission->score && $submission->pdf_path)
                            <a href="{{ Storage::url($submission->pdf_path) }}" target="_blank" 
                                class="text-xs text-blue-600 hover:text-blue-800 hover:underline">
                                View Article
                            </a>
                        @elseif($submission->score)
                            <div class="flex flex-col items-center space-y-2">
                                <form action="{{ route('request.article.upload', $submission->serial_number) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                        class="inline-block px-3 py-1 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-full">
                                        Request Article
                                    </button>  
                                </form>
                                
                                <button @click="isOpen = true" 
                                    class="inline-flex items-center space-x-1 px-3 py-1 text-xs text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-100 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>Preview Abstract</span>
                                </button>
                            </div>

                            <!-- Modal Backdrop -->
                            <div x-show="isOpen"
                                x-cloak 
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="fixed inset-0 bg-black bg-opacity-50 z-40"
                                @click="isOpen = false">
                            </div>

                            <!-- Modal Container -->
                            <div x-show="isOpen"
                                x-cloak
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-4"
                                class="fixed inset-0 z-50 overflow-y-auto"
                                @click.away="isOpen = false">
                                
                                <div class="min-h-screen px-4 text-center">
                                    <!-- Modal Panel -->
                                    <div class="inline-block w-full max-w-4xl p-6 my-8 text-left align-middle bg-white rounded-lg shadow-xl transform transition-all">
                                        <!-- Header -->
                                        <div class="flex justify-between items-center pb-3 border-b">
                                            <h3 class="text-lg font-medium text-gray-900">Research Abstract Preview</h3>
                                            <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Content -->
                                        <div class="mt-4 max-h-[70vh] overflow-y-auto">
                                            <!-- Title -->
                                            <h1 class="text-2xl font-serif text-center font-bold mb-6">
                                                {{ $submission->title }}
                                            </h1>

                                            <!-- Authors -->
                                            <div class="text-center mb-8">
                                                @php
                                                    $authors = json_decode($submission->authors, true);
                                                @endphp
                                                @if($authors && is_array($authors))
                                                    <div class="flex flex-wrap justify-center gap-1 mb-2">
                                                        @foreach($authors as $author)
                                                            <span class="font-serif text-sm">
                                                                {{ $author['first_name'] }} {{ $author['middle_name'] ?? '' }} {{ $author['surname'] }}
                                                                @if($author['is_correspondent'])
                                                                    <span class="text-blue-600">*</span>
                                                                @endif
                                                                @if(!$loop->last), @endif
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                    <!-- Affiliation -->
                                                    <div class="space-y-1 text-gray-600">
                                                        <p class="font-serif text-xs">{{ $author['university'] }}</p>
                                                        <p class="font-serif text-xs">{{ $author['department'] }}</p>
                                                    </div>
                                                @else
                                                    <p class="text-gray-500 italic text-sm">No authors available</p>
                                                @endif
                                            </div>

                                            <!-- Abstract -->
                                            <div class="space-y-4">
                                                <h2 class="text-lg font-bold text-gray-900">Abstract</h2>
                                                <p class="text-sm text-gray-700 leading-relaxed text-justify">
                                                    {{ $submission->abstract }}
                                                </p>
                                            </div>

                                            <!-- Keywords -->
                                            <div class="mt-6">
                                                <h3 class="text-sm font-bold text-gray-900">Keywords</h3>
                                                <p class="text-sm text-gray-700">
                                                    {{ implode(', ', json_decode($submission->keywords)) }}
                                                </p>
                                            </div>

                                            <!-- Sub-Theme -->
                                            <div class="mt-4">
                                                <h3 class="text-sm font-bold text-gray-900">Sub-Theme</h3>
                                                <p class="text-sm text-gray-700">{{ $submission->sub_theme }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($submission->pdf_path)
                            <a href="{{ Storage::url($submission->pdf_path) }}" target="_blank" 
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
                                                class="block w-full text-left px-4 py-2 text-sm text-grey-700 hover:text-white hover:bg-green-800">
                                                Accept
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
                                        <a href="" 
                                            class="block w-full text-left px-4 py-2 text-sm text-green-900 hover:bg-gray-100">
                                            User Revision
                                        </a>
                                        <button type="button" 
                                                data-submission-id="{{ $submission->serial_number }}"
                                                class="reviewer-revision-btn block w-full text-left px-4 py-2 text-sm text-green-900 hover:bg-gray-100">
                                                Reviewer Revision
                                        </button>
                                        <form action="" method="POST" class="contents">
                                            @csrf
                                            <input type="hidden" name="serial_number" value="{{ $submission->serial_number }}">
                                            <button type="submit" 
                                                class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:text-white hover:bg-red-800">
                                                Reject
                                            </button>
                                        </form>
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
            </tbody>
        </table>
        </div>
    </div>





    <!-- Research Proposals Tab Content -->
    <div x-show="activeTab === 'proposals'">
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
        <div class="flex justify-between items-center mb-4">
    <!-- Bulk Selection -->
    <div class="flex items-center space-x-2">
        <input type="checkbox" id="select-all-proposals" 
               class="w-4 h-4 text-indigo-600 border-gray-300 rounded"
               onclick="toggleSelectAllProposals(this)">
        <label for="select-all-proposals" class="text-sm text-gray-700">Select All</label>
    </div>

    <!-- Reviewer Selection and Assign Button -->
    <div class="flex items-center space-x-4">
        <select id="proposal-reviewer-dropdown" 
                name="reviewer" 
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                required>
            <option value="">Select Reviewer</option>
            @foreach ($reviewers as $reviewer)
                <option value="{{ $reviewer->reg_no }}">{{ $reviewer->name }}</option>
            @endforeach
        </select>
        <button onclick="assignReviewers()" 
                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
            Assign Reviewer
        </button>
    </div>
</div>
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">
                        <input type="checkbox" id="select-all" class="w-4 h-4 text-indigo-600 border-gray-300 rounded">
                    </th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Submitted By</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Submission Date</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Score</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Reviewer</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Related Documents</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($researchSubmissions as $researchSubmission)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 text-center">
                        <input type="checkbox" class="proposal-submission-checkbox w-4 h-4 text-indigo-600 border-gray-300 rounded" 
                            value="{{ $researchSubmission->serial_number }}">
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        <div class="font-medium">{{ $researchSubmission->article_title }}</div>
                        <div class="text-xs text-gray-500">{{ $researchSubmission->serial_number }}</div>
                    </td>
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
                    <td class="relative" x-data="{ isOpen: false }">
                        <div class="flex flex-col items-center space-y-2">
                            <a href="{{ asset('storage/' . $researchSubmission->pdf_document_path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                                View Proposal
                            </a>

                            <!-- Preview Button -->
                            <button @click="isOpen = true" class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:text-gray-900 rounded-md hover:bg-gray-100 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Preview Abstract</span>
                            </button>
                        </div>

                        <!-- Modal Backdrop -->
                        <div x-show="isOpen" 
                            x-cloak
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 bg-black bg-opacity-50 z-40"
                            @click="isOpen = false">
                        </div>

                        <!-- Modal Container -->
                        <div x-show="isOpen"
                            x-cloak
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-4"
                            class="fixed inset-0 z-50 overflow-y-auto"
                            @click.away="isOpen = false">
                            
                            <div class="min-h-screen px-4 text-center">
                                <!-- Modal Panel -->
                                <div class="inline-block w-full max-w-4xl p-6 my-8 text-left align-middle bg-white shadow-xl transform transition-all">
                                    <!-- Header -->
                                    <div class="flex justify-between items-center pb-3 border-b">
                                        <h3 class="text-lg font-medium text-gray-900">Research Abstract Preview</h3>
                                        <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Content -->
                                    <div class="mt-4 max-h-[70vh] overflow-y-auto">
                                        <!-- Title -->
                                        <h1 class="text-2xl font-serif text-center font-bold mb-6">
                                            {{ $researchSubmission->article_title }}
                                        </h1>

                                        <!-- Authors -->
                                        <div class="text-center mb-8">
                                            @php
                                                $authors = json_decode($researchSubmission->authors, true);
                                            @endphp
                                            @if($authors && is_array($authors))
                                                <div class="flex flex-wrap justify-center gap-1 mb-2">
                                                    @foreach($authors as $author)
                                                        <span class="font-serif text-sm">
                                                            {{ $author['first_name'] }} {{ $author['middle_name'] ?? '' }} {{ $author['surname'] }}
                                                            @if($author['is_correspondent'])
                                                                <span class="text-black-600">*</span>
                                                            @endif
                                                            @if(!$loop->last), @endif
                                                        </span>
                                                    @endforeach
                                                </div>
                                                <!-- Affiliation -->
                                                <div class="space-y-1 text-gray-600">
                                                    <p class="font-serif text-xs">{{ $author['university'] }}</p>
                                                    <p class="font-serif text-xs">{{ $author['department'] }}</p>
                                                </div>
                                            @else
                                                <p class="text-gray-500 italic">No authors available</p>
                                            @endif
                                        </div>

                                        <!-- Abstract -->
                                        <div class="space-y-4">
                                            <h2 class="text-lg font-bold text-gray-900">Abstract</h2>
                                            <p class="text-gray-700 leading-relaxed text-justify">
                                                {{ $researchSubmission->abstract }}
                                            </p>
                                        </div>

                                        <!-- Keywords -->
                                        <div class="mt-6">
                                            <h3 class="font-bold text-gray-900">Keywords</h3>
                                            <p class="text-gray-700">
                                                {{ implode(', ', json_decode($researchSubmission->keywords)) }}
                                            </p>
                                        </div>

                                        <!-- Sub-Theme -->
                                        <div class="mt-4">
                                            <h3 class="font-bold text-gray-900">Sub-Theme</h3>
                                            <p class="text-gray-700">{{ $researchSubmission->sub_theme }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                        <a href="{{ route('download.file', ['serialNumber' => $researchSubmission->serial_number]) }}" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Download Proposal
                                        </a>
                                        <a href="" 
                                            class="block w-full text-left px-4 py-2 text-sm text-green-900 hover:bg-gray-100">
                                            User Revision
                                        </a>
                                        <a href="" 
                                            class="block w-full text-left px-4 py-2 text-sm text-green-900 hover:bg-gray-100">
                                            Reviewer Revision
                                        </a>
                                        <button class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100"
                                                onclick="openModal('add-comments-modal-{{ $researchSubmission->serial_number }}')">
                                                Reject
                                        </button>
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
</div>
<script>
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
// Function to toggle the "Select All" checkbox
function toggleSelectAllAbstracts(source) {
    const checkboxes = document.querySelectorAll('.abstract-submission-checkbox');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = source.checked;
    });
}

// Function to handle assigning reviewers to selected submissions
function assignAbstractReviewers() {
    const selectedSubmissions = Array.from(document.querySelectorAll('.abstract-submission-checkbox:checked'))
        .map((checkbox) => checkbox.value); // Collect all selected submission IDs
    const selectedReviewer = document.getElementById('reviewer-dropdown').value; // Get the selected reviewer

    if (selectedSubmissions.length === 0) {
        alert('Please select at least one submission.');
        return;
    }

    if (!selectedReviewer) {
        alert('Please select a reviewer.');
        return;
    }

    // Send the selected submissions and reviewer to the server via a POST request
    fetch('{{ route('assign.mass.reviewer') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            submissions: selectedSubmissions,
            reviewer: selectedReviewer,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                showNotification('success', data.message || 'Reviwer assigned successfully.');
                setTimeout(() => {
                        location.reload();
                }, 1000);
            } else if (data.error) {
                showNotification('success', data.message || 'Error assigning reviewer. Try again');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}
 
function toggleSelectAllProposals(source) {
    const checkboxes = document.querySelectorAll('.proposal-submission-checkbox');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = source.checked;
    });
}

function assignReviewers() {
    const selected = Array.from(document.querySelectorAll('.proposal-submission-checkbox:checked'))
        .map((checkbox) => checkbox.value);

    const reviewer = document.getElementById('proposal-reviewer-dropdown').value;

    if (selected.length === 0) {
        alert('Please select at least one submission.');
        return;
    }

    if (!reviewer) {
        alert('Please select a reviewer.');
        return;
    }

    // Make a POST request to assign reviewers
    fetch('{{ route('assign.proposal.massReviewer') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            submissions: selected,
            reviewer: reviewer,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                showNotification('success', data.message || 'Reviwer assigned successfully.');
                setTimeout(() => {
                        location.reload();
                }, 1000);
            } else if (data.error) {
                showNotification('success', data.message || 'Error assigning reviewer. Try again');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.reject-score-btn').forEach(button => {
        button.addEventListener("click", async function () {
            const serial_number = this.dataset.submissionId;
            
            if (!confirm("Are you sure you want to reject this score? This action cannot be undone.")) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/reject/assessment/${serial_number}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    }
                });

                const data = await response.json();
                
                if (response.ok) {
                    // Show success message
                    showNotification(data.message || "Score rejected successfully", 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || "Failed to reject score");
                }
            } catch (error) {
                showNotification(error.message || "An error occurred. Please try again later.", 'error');
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.reviewer-revision-btn').forEach(button => {
        button.addEventListener("click", async function () {
            const serial_number = this.dataset.submissionId;

            try {
                const response = await fetch(`/admin/reviewer-abstract-revision/${serial_number}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "Accept": "application/json"
                    }
                });

                const data = await response.json();
                
                if (response.ok) {
                    // Show success message
                    showNotification(data.message || "Revision request successfully", 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || "Failed to request revision");
                }
            } catch (error) {
                showNotification(error.message || "An error occurred. Please try again later.", 'error');
            }
        });
    });
});
</script>
@endsection