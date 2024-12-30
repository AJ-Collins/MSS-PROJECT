@extends('reviewer.layouts.reviewer')

@section('reviewer-content')
<!-- Enhanced Document Management Section -->
<div x-data="{ activeTab: 'articles', searchQuery: '', showFilters: false, statusFilter: 'all' }">
    <div class="border-b border-gray-200 shadow-sm bg-white">
        <div class="flex justify-between items-center p-4">
            <h2 class="text-2xl font-semibold text-gray-800 tracking-tight">Review Documents</h2>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Search documents..."
                        class="w-64 px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <!-- Enhanced Tabbed Navigation Menu -->
    <div class="bg-white border-b border-gray-200">
        <div class="flex">
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150 flex items-center gap-2"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'articles', 'border-transparent': activeTab !== 'articles' }"
                @click="activeTab = 'articles'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Articles
                <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs">{{ $abstractCount }}</span>
            </button>
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150 flex items-center gap-2"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'proposals', 'border-transparent': activeTab !== 'proposals' }"
                @click="activeTab = 'proposals'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Research Proposals
                <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs">{{ $proposalCount }}</span>
            </button>
        </div>
    </div>

    <!-- Enhanced Tab Content -->
        <div class="bg-white shadow-sm">
            <!-- Enhanced Abstracts Tab -->
            <div x-show="activeTab === 'articles'" class="overflow-x-auto" x-data="{ selectedItems: [] }">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Sub_Theme</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Score</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Remarks</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submissions as $submission)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-center">
                                <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <div class="text-sm font-medium text-gray-900">{{ $submission->title }}</div>
                                <div class="text-xs text-gray-500">{{ $submission->serial_number }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $submission->sub_theme }}</td>
                            <td class="px-4 py-3 text-center text-sm text-gray-700 group relative">
                                {{ $submission->score ?? 'Assess file' }}
                                <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-max px-3 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    {{ $submission->score ? "{$submission->score} marks assigned after assessment" : "Assess the document and assign marks" }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-700">Good (Remarks)</td>
                            <td class="px-4 py-3 text-center text-sm text-gray-700">
                                <div class="flex justify-center p-2">
                                    @if ($submission->score && $submission->score > 30)
                                        <!-- Display message if score is above 30 -->
                                        <span class="text-green-600">Score passed minimum</span>
                                        <span class="ml-2 relative group">
                                            <svg class="w-5 h-5 text-gray-600 group-hover:text-blue-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            <!-- Tooltip text -->
                                            <span class="absolute bottom-full mb-1 left-1/2 transform -translate-x-1/2 text-sm bg-gray-800 text-white rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                Request Revision
                                            </span>
                                        </span>
                                    @else
                                        <!-- Display button to request revision if score is below 30 -->
                                        <a href="" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            Request Revision
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <button class="group relative p-2 text-gray-600 hover:text-green-800 rounded-full hover:bg-green-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Accept</span>
                                    </button>
                                    <button class="group relative p-2 text-gray-600 hover:text-red-600 rounded-full hover:bg-red-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Reject</span>
                                    </button>
                                    <a href="{{ route('research.abstract.download', $submission->serial_number) }}" class="group relative p-2 text-gray-600 hover:text-indigo-600 rounded-full hover:bg-indigo-100 transition-colors duration-200">
                                        <!-- PDF icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                        </svg>
                                        <!-- Tooltip -->
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                            Download PDF
                                        </span>
                                    </a>
                                    <a href="{{ route('abstract.abstractWord.download', $submission->serial_number) }}" class="group relative p-2 text-gray-600 hover:text-indigo-600 rounded-full hover:bg-indigo-100 transition-colors duration-200">
                                        <!-- Word document icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h1.5m1.5 0H13m-2.5 4H13m-2.5 4H13"/>
                                        </svg>
                                        <!-- Tooltip -->
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                            Download Word
                                        </span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center text-sm text-gray-600">
                                No articles assigned yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
        <!-- Research Proposals Tab (Hidden by default) -->
        <div x-show="activeTab === 'proposals'" class="p-4" style="display: none;">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <td class="px-4 py-3 text-center">
                        <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    </td>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Sub_Theme</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Score</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Remarks</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($researchSubmissions as $researchSubmission)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <div class="text-sm font-medium text-gray-900">{{ $researchSubmission->article_title }}</div>
                            <div class="text-xs text-gray-500">{{ $researchSubmission->serial_number }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $researchSubmission->sub_theme }}</td>
                        <td class="px-4 py-3 text-center text-sm text-gray-700 group relative">
                            {{ $researchSubmission->score ?? 'Assess file' }}
                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-max px-3 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                {{ $researchSubmission->score ? "{$researchSubmission->score} marks assigned after assessment" : "Assess the document and assign marks" }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-700">Good (Remarks)</td>
                        <td class="px-4 py-3 text-center text-sm text-gray-700">
                            <div class="flex justify-center p-2">
                            @if ($researchSubmission->score && $researchSubmission->score > 30)
                                <!-- Display message if score is above 30 -->
                                <span class="text-green-600">This article has passed the review!</span>
                            @else
                                <!-- Display button to request revision if score is below 30 -->
                                <a href="" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-all">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Request Revision
                                </a>
                            @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center space-x-2">
                                <button class="group relative p-2 text-gray-600 hover:text-green-600 rounded-full hover:bg-green-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Accept</span>
                                </button>
                                <button class="group relative p-2 text-gray-600 hover:text-red-600 rounded-full hover:bg-red-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">Reject</span>
                                </button>
                                <a href="{{ route('proposal.abstract.download', $researchSubmission->serial_number) }}" class="group relative p-2 text-gray-600 hover:text-indigo-600 rounded-full hover:bg-indigo-100 transition-colors duration-200">
                                    <!-- PDF icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                    </svg>
                                    <!-- Tooltip -->
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                        Download PDF
                                    </span>
                                </a>
                                <a href="{{ route('proposal.abstractWord.download', $researchSubmission->serial_number) }}" class="group relative p-2 text-gray-600 hover:text-indigo-600 rounded-full hover:bg-indigo-100 transition-colors duration-200">
                                    <!-- Word document icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9h1.5m1.5 0H13m-2.5 4H13m-2.5 4H13"/>
                                    </svg>
                                    <!-- Tooltip -->
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                        Download Word
                                    </span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-center text-sm text-gray-600">
                            No articles assigned yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
</table>

        </div>
    </div>
</div>

<!-- Enhanced Document Review Form -->
<!-- Enhanced Document Review Form -->
<div class="mt-8 bg-white p-6 rounded-lg shadow-sm" x-data="{ rating: 0, feedbackType: 'general', showGuide: false }">
    <div class="flex justify-between items-center mb-6">
        <button 
            @click="showGuide = !showGuide"
            class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Review Guidelines
        </button>
    </div>

    <!-- Review Guidelines Panel -->
    <div x-show="showGuide" class="mb-6 bg-indigo-50 p-4 rounded-lg">
        <h4 class="font-medium text-indigo-800 mb-2">Review Guidelines</h4>
        <ul class="text-sm text-indigo-700 space-y-2">
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Provide specific, actionable feedback that helps authors improve their work
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Be constructive and respectful in your criticism
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Support your assessment with concrete examples
            </li>
        </ul>
    </div>
</div>

@endsection