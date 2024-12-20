@extends('reviewer.layouts.reviewer')

@section('reviewer-content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Reviewer Dashboard</h1>
    <p class="mt-2 text-sm text-gray-600">Review, rate, and provide feedback on submitted documents. Approve, request revisions, or reject submissions as necessary.</p>
</div>

<!-- Stats & Overview Section -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Pending Reviews Card -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-600">Pending Reviews</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-2">12</h3>
                <p class="text-xs text-green-600 mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    +2 from last week
                </p>
            </div>
            <div class="p-3 bg-blue-50 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <p class="text-sm text-gray-600 mt-2">Documents awaiting your review</p>
    </div>

    <!-- Approved Documents Card -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-600">Approved Documents</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-2">45</h3>
                <p class="text-xs text-green-600 mt-2 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    +5 this month
                </p>
            </div>
            <div class="p-3 bg-green-50 rounded-full">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-sm text-gray-600 mt-2">Successfully approved submissions</p>
    </div>

    <!-- Review Time Card -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-600">Average Review Time</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-2">2.5 days</h3>
            </div>
            <div class="p-3 bg-indigo-50 rounded-full">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-sm text-gray-600 mt-2">Your typical response time</p>
    </div>

    <!-- High Priority Card -->
    <div class="bg-red-50 p-6 rounded-lg shadow-sm border border-red-200">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-red-600">High Priority</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-2">3</h3>
            </div>
            <div class="p-3 bg-red-100 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-sm text-red-600 mt-2">Urgent reviews needed</p>
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

    <!-- Tab Content - Abstracts, Articles, and Proposals -->
    <div class="bg-white shadow-sm">
        <!-- Abstracts Tab -->
        <div x-show="activeTab === 'abstracts'" class="overflow-x-auto">
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
                    <!-- Example Submission -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">Abstract 1.pdf</td>
                        <td class="px-4 py-3 text-sm text-gray-700">Jane Smith</td>
                        <td class="px-4 py-3 text-sm text-gray-500">2024-12-20</td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">To Review</span>
                        </td>
                        <td class="px-4 py-3 text-center space-x-2">
                            <!-- Actions: Review, Approve, Decline, Download -->
                            <button class="px-2 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">Review</button>
                            <button class="px-2 py-1 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-full">Approve</button>
                            <button class="px-2 py-1 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded-full">Decline</button>
                            <button class="px-2 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-full">Download</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Articles Tab (Similar Layout as Abstracts) -->
        <div x-show="activeTab === 'articles'" class="p-4">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <!-- Same headers and structure as Abstracts -->
                </thead>
                <tbody>
                    <!-- Example Submission -->
                    <tr class="border-b hover:bg-gray-50">
                        <!-- Document details and actions -->
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Research Proposals Tab (Similar Layout as Abstracts) -->
        <div x-show="activeTab === 'proposals'" class="p-4">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <!-- Same headers and structure as Abstracts -->
                </thead>
                <tbody>
                    <!-- Example Submission -->
                    <tr class="border-b hover:bg-gray-50">
                        <!-- Document details and actions -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Document Review and Feedback Section -->
<div class="mt-8 bg-white p-6 rounded-lg shadow-sm">
    <h3 class="text-xl font-semibold text-gray-800">Review Document</h3>
    <form class="mt-4">
        <label for="feedback" class="block text-sm font-medium text-gray-600">Provide Your Feedback</label>
        <textarea id="feedback" class="mt-2 p-2 w-full h-40 border border-gray-300 rounded-md" placeholder="Add your comments or suggestions here..."></textarea>

        <div class="mt-4">
            <label for="rating" class="block text-sm font-medium text-gray-600">Rating</label>
            <select id="rating" class="mt-2 p-2 w-full border border-gray-300 rounded-md">
                <option value="1">1 - Poor</option>
                <option value="2">2 - Fair</option>
                <option value="3">3 - Good</option>
                <option value="4">4 - Very Good</option>
                <option value="5">5 - Excellent</option>
            </select>
        </div>

        <div class="mt-4">
            <button type="submit" class="px-4 py-2 text-white bg-green-600 hover:bg-green-700 rounded-md">Submit Review</button>
        </div>
    </form>
</div>

@endsection
