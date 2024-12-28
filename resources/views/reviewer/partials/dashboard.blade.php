@extends('reviewer.layouts.reviewer')

@section('reviewer-content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">| Dashboard</h1>
    <p class="mt-2 text-sm text-gray-600">Review, rate, and provide feedback on submitted documents. Approve, request revisions, or reject submissions as necessary.</p>
</div>

<!-- Stats & Overview Section -->
<!-- Dashboard Content -->                
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Stats Card 1 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Articles</p>
                                <p class="text-2xl font-semibold text-gray-700">{{ $abstractCount }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Stats Card 2 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Proposals</p>
                                    <p class="text-2xl font-semibold text-gray-700">{{ $proposalCount }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card 3 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Pending</p>
                                <p class="text-2xl font-semibold text-gray-700">3</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Card 4 -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Rivisions</p>
                                <p class="text-2xl font-semibold text-gray-700">3</p>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Document Management Section -->
<div x-data="{ activeTab: 'abstracts' }">
    <div class="border-b border-gray-200 shadow-sm bg-white">
        <h2 class="text-2xl font-semibold text-gray-800 tracking-tight p-4">Document Management</h2>
    </div>

    <!-- Tabbed Navigation Menu -->
    <div class="bg-white border-b border-gray-200">
        <div class="flex">
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'abstracts', 'border-transparent': activeTab !== 'abstracts' }"
                @click="activeTab = 'abstracts'">
                Articles
                <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs">3</span>
            </button>
            <button 
                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150"
                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'proposals', 'border-transparent': activeTab !== 'proposals' }"
                @click="activeTab = 'proposals'">
                Research Proposals
                <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full text-xs">2</span>
            </button>
        </div>
    </div>

    <!-- Tab Content - Abstracts, Articles, and Proposals -->
    <div class="bg-white shadow-sm">
        <!-- Articles Tab -->
        <div x-show="activeTab === 'abstracts'" class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Serial_No</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Sub_Theme</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submissions as $submission)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $submission->serial_number }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $submission->title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $submission->sub_theme }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">To Review</span>
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <button 
                                class="px-2 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full"
                                @click="$store.modal.open()"
                            >
                                Review
                            </button>
                            <a href="{{ route('research.abstract.download', $submission->serial_number) }}" class="px-2 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">
                                Download
                            </a>
                        </td>
                        <!-- Modal -->
                        <div 
                            x-data="{ zoomLevel: 100 }"
                            x-show="$store.modal.isOpen"
                            @keydown.escape.window="$store.modal.close()"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                        >
                            <div 
                                class="w-1/2 h-[80vh] flex flex-col bg-gray-50 rounded-lg shadow-lg"
                                @click.away="$store.modal.close()"
                            >
                                <!-- Header -->
                                <div class="flex-none bg-white border-b border-gray-200">
                                    <div class="px-6 py-4 flex items-center justify-between">
                                        <div>
                                            <h2 class="text-lg font-semibold text-gray-900">Document Preview</h2>
                                            <p class="mt-1 text-sm text-gray-500">Abstract</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-gray-600" x-text="`${zoomLevel}%`"></span>
                                            <button 
                                                @click="zoomLevel = Math.max(10, zoomLevel - 10)" 
                                                class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg" 
                                                title="Zoom Out"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <button 
                                                @click="zoomLevel += 10" 
                                                class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg" 
                                                title="Zoom In"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                            <button 
                                                @click="$store.modal.close()" 
                                                class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg" 
                                                title="Close"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Document Viewer -->
                                <div class="flex-1 overflow-y-auto p-6">
                                    <div 
                                        class="bg-white rounded-xl shadow-sm h-full border border-gray-200"
                                        :style="`transform: scale(${zoomLevel/100}); transform-origin: top left;`"
                                    >
                                        <div class="h-full flex items-center justify-center border-2 border-dashed border-gray-200 rounded-xl p-8">
                                            <div class="text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <h3 class="mt-2 text-sm font-medium text-gray-900">Document Preview</h3>
                                                <p class="mt-1 text-sm text-gray-500">PDF, DOCX, or other document formats</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Footer with Accept/Decline buttons -->
                                <div class="flex-none bg-white border-t border-gray-200 px-6 py-4">
                                    <div class="flex justify-end space-x-2">
                                        <button 
                                            class="px-2 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full"
                                            @click="$store.modal.close()"
                                        >
                                            Accept
                                        </button>
                                        <button 
                                            class="px-2 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-full"
                                            @click="$store.modal.close()"
                                        >
                                            Decline
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                    @empty
                    <tr>
                    <td colspan="3" class="px-4 py-2 text-center">No abstracts assigned yet.</td>
                </tr>
            @endforelse
                </tbody>
            </table>
        </div>

        <!-- Research Proposals Tab (Similar Layout as Abstracts) -->
        <div x-show="activeTab === 'proposals'" class="p-4">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Serial_No</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Sub_Theme</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>        
                <tbody>
                    @forelse ($researchSubmissions as $researchSubmission)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $researchSubmission->serial_number }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $researchSubmission->article_title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $researchSubmission->sub_theme }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">To Review</span>
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <button 
                                class="px-2 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full"
                                @click="$store.modal.open()"
                            >
                                Review
                            </button>
                            <a href="{{ route('proposal.abstract.download', $researchSubmission->serial_number) }}" class="px-2 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">
                                Download
                            </a>
                        </td>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center">No proposals assigned yet.</td>
                        </tr>
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('modal', {
        isOpen: false,
        open() {
            this.isOpen = true
        },
        close() {
            this.isOpen = false
        }
    })
})
</script>
@endsection
