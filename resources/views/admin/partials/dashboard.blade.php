@extends('admin.layouts.admin')

@section('admin-content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">| Dashboard</h1>
        <p class="mt-2 text-sm text-gray-600">Welcome back to your admin dashboard</p>
</div>
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
                                <p class="text-2xl font-semibold text-gray-700">{{ $totalAbstracts }}</p>
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
                                    <p class="text-2xl font-semibold text-gray-700">{{ $totalProposals }}</p>
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
                                <p class="text-sm text-gray-500">Users</p>
                                <p class="text-2xl font-semibold text-gray-700">{{ $totalUsers }}</p>
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
                                <p class="text-sm text-gray-500">Reviewers</p>
                                <p class="text-2xl font-semibold text-gray-700">{{ $totalReviewers }}</p>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Wrap everything in a single Alpine.js component -->
    <div x-data="{ activeTab: 'abstracts' }">
        <div class="border-b border-gray-200 shadow-sm bg-white">
            <h2 class="text-2xl font-semibold text-gray-800 tracking-tight p-4">Recents</h2>
        </div>

        <!-- Tabbed Menu - Removed extra padding -->
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
                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'articles', 'border-transparent': activeTab !== 'articles' }"
                    @click="activeTab = 'articles'">
                    Articles
                </button>
                <button 
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 border-b-2 transition-colors duration-150"
                    :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'proposals', 'border-transparent': activeTab !== 'proposals' }"
                    @click="activeTab = 'proposals'">
                    Research Proposals
                </button>
            </div>
        </div>

        <!-- Tab Content - Adjusted spacing -->
        <div class="bg-white shadow-sm">
            <!-- Abstracts Tab -->
            <div x-show="activeTab === 'abstracts'" class="overflow-x-auto">
                <table class="min-w-full table-auto">                
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Serial Number</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Uploaded By</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Uploaded On</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($submissions as $submission)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $submission->serial_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $submission->user_reg_no }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y') }}</td>
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
                            <td class="px-4 py-3 text-center space-x-2">
                                <button class="px-2 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">View</button>                            
                                <button class="px-2 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">Download</button>
                            </td>
                        </tr> 
                        @endforeach                       
                    </tbody>
                </table>
            </div>

            <!-- Articles Tab -->
            <div x-show="activeTab === 'articles'" class="p-4">
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
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">Abstract 1.pdf</td>
                            <td class="px-4 py-3 text-sm text-gray-700">Jane Smith</td>
                            <td class="px-4 py-3 text-sm text-gray-500">2024-12-20</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">To Review</span>
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <button class="px-2 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">Review</button>                           
                                <button class="px-2 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">Download</button>
                            </td>
                        </tr>                        
                    </tbody>
                </table>
            </div>

            <!-- Research Proposals Tab -->
            <div x-show="activeTab === 'proposals'" class="p-4">
            <table class="min-w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Serial Number</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Uploaded By</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Uploaded On</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($researchSubmissions as $researchSubmission)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $researchSubmission->serial_number}}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $researchSubmission->user_reg_no }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ \Carbon\Carbon::parse($researchSubmission->created_at)->format('d M Y') }}</td>
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
                            <td class="px-4 py-3 text-center space-x-2">
                              <button class="px-2 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">View</button>
                                <button class="px-2 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">Download</button>
                            </td>
                        </tr>  
                    @endforeach                 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection