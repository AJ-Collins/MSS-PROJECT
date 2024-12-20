@extends('reviewer.layouts.reviewer')

@section('reviewer-content')
<!-- Document Preview & Review Section -->
<div x-data="{ showPreview: false, currentDocument: null }" class="mt-8">
    <!-- Preview Modal -->
    <div x-show="showPreview" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showPreview = false"></div>
            
            <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="currentDocument?.name"></h3>
                    <button @click="showPreview = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="p-6">
                    <!-- PDF/Document Viewer -->
                    <div class="bg-gray-100 rounded-lg h-96 mb-4">
                        <iframe x-bind:src="currentDocument?.url" class="w-full h-full rounded-lg"></iframe>
                    </div>

                    <!-- Quick Review Actions -->
                    <div class="flex space-x-4 mt-4">
                        <button class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Approve Document
                        </button>
                        <button class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Request Revision
                        </button>
                        <button class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                            Download
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Document Table -->
    <div class="bg-white shadow-sm rounded-lg">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Document Name</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Type</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Submitted By</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Date</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Version</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-gray-700">Research_Paper_v1.pdf</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">Article</td>
                    <td class="px-4 py-3 text-sm text-gray-700">John Doe</td>
                    <td class="px-4 py-3 text-sm text-gray-500">2024-12-20</td>
                    <td class="px-4 py-3 text-center text-sm text-gray-500">1.0</td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                            Pending Review
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <button 
                                @click="showPreview = true; currentDocument = {
                                    name: 'Research_Paper_v1.pdf',
                                    url: '/path/to/document.pdf'
                                }"
                                class="px-2 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-full">
                                Preview
                            </button>
                            <div class="relative" x-data="{ open: false }">
                                <button 
                                    @click="open = !open"
                                    class="px-2 py-1 text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-full">
                                    More
                                </button>
                                <!-- Dropdown menu -->
                                <div 
                                    x-show="open"
                                    @click.away="open = false"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10"
                                    style="display: none;">
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Download</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View History</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Share</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    <!-- Enhanced Review Form -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow-sm">
        <h3 class="text-xl font-semibold text-gray-800">Document Review</h3>
        
        <form class="mt-4 space-y-6">
            <!-- Review Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Review Type</label>
                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option>Initial Review</option>
                    <option>Revision Review</option>
                    <option>Final Review</option>
                </select>
            </div>

            <!-- Rating Section -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Rating</label>
                <div class="mt-2 flex items-center space-x-2">
                    <template x-for="i in 5">
                        <button 
                            type="button"
                            class="text-gray-300 hover:text-yellow-400">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Review Categories -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Methodology</label>
                    <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="5">Excellent</option>
                        <option value="4">Good</option>
                        <option value="3">Average</option>
                        <option value="2">Fair</option>
                        <option value="1">Poor</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Originality</label>
                    <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="5">Excellent</option>
                        <option value="4">Good</option>
                        <option value="3">Average</option>
                        <option value="2">Fair</option>
                        <option value="1">Poor</option>
                    </select>
                </div>
            </div>

            <!-- Feedback -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Detailed Feedback</label>
                <textarea 
                    rows="6" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Provide your detailed feedback here..."></textarea>
            </div>

            <!-- Revision Requirements -->
            <div x-data="{ requiresRevision: false }">
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="requires-revision"
                        x-model="requiresRevision"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="requires-revision" class="ml-2 block text-sm text-gray-700">
                        Requires Revision
                    </label>
                </div>
                
                <div x-show="requiresRevision" class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Revision Requirements</label>
                    <textarea 
                        rows="4" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="List specific revision requirements..."></textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Submit Review
                </button>
                <button type="button" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Draft
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
