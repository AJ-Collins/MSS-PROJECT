@extends('reviewer.layouts.reviewer')

@section('reviewer-content')
<div x-data="{ 
    showPreview: false,
    currentDocument: null,
    showHistory: false,
    reviewProgress: 0,
    filters: {
        status: 'all',
        type: 'all',
        dateRange: 'all'
    }
}" class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Reviewer Dashboard</h1>
        <p class="text-gray-600">Manage and review submitted articles</p>
    </div>

    <!-- Filters Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select x-model="filters.status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="all">All Status</option>
                    <option value="pending">Pending Review</option>
                    <option value="reviewed">Reviewed</option>
                    <option value="revision">Needs Revision</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Article Type</label>
                <select x-model="filters.type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="all">All Types</option>
                    <option value="research">Research Paper</option>
                    <option value="article">Article</option>
                    <option value="review">Review Paper</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date Range</label>
                <select x-model="filters.dateRange" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="all">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Search articles...">
            </div>
        </div>
    </div>

    <!-- Articles Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!@foreach($articles as $article)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $article->title }}</div>
                                <div class="text-sm text-gray-500">{{ $article->type }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $article->author_name }}</div>
                        <div class="text-sm text-gray-500">{{ $article->author_email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $article->submitted_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($article->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($article->status === 'reviewed') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($article->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('reviewer.review', $article->id) }}" class="text-green-600 hover:text-green-900">Review</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $articles->links() }}
        </div>
    </div>

    <!-- Review Form Modal -->
    <div x-show="showPreview" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showPreview = false"></div>
            
            <div class="relative bg-white rounded-lg w-full max-w-4xl">
                <form action="{{ route('reviewer.submitReview') }}" method="POST" class="p-6">
                    @csrf
                    <input type="hidden" name="article_id" x-bind:value="currentDocument?.id">
                    
                    <!-- Scoring Sections -->
                    <div class="space-y-6">
                        <!-- Research Thematic Area -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-lg font-semibold text-green-700">
                                Research Thematic Area <span class="text-red-500">(Out of 5)</span>
                            </label>
                            <div class="flex items-center space-x-4 mt-2">
                                <textarea name="thematic_area_comments" class="flex-1 rounded-md border-gray-300" rows="3" required></textarea>
                                <input type="number" name="thematic_area_score" class="w-20 rounded-md border-gray-300" min="0" max="5" required>
                            </div>
                        </div>

                        <!-- Similar sections for other scoring criteria -->
                        <!-- Add the remaining scoring sections following the same pattern -->

                        <!-- General Comments -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-lg font-semibold text-green-700">General Comments</label>
                            <textarea name="general_comments" class="w-full mt-2 rounded-md border-gray-300" rows="4" required></textarea>
                        </div>

                        <!-- Review Decision -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-lg font-semibold text-green-700">Review Decision</label>
                            <div class="mt-2 space-y-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="decision" value="accept" class="text-green-600">
                                    <span class="ml-2">Accept</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="decision" value="minor_revision" class="text-yellow-600">
                                    <span class="ml-2">Minor Revision</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="decision" value="major_revision" class="text-orange-600">
                                    <span class="ml-2">Major Revision</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="decision" value="reject" class="text-red-600">
                                    <span class="ml-2">Reject</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" @click="showPreview = false" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection