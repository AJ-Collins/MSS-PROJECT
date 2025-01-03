@extends('user.layouts.user')

@section('user-content')
<!-- Progress Tracker -->
<div class="max-w-4xl mx-auto mb-8">
    <!-- Your existing progress tracker code here -->
</div>

<!-- Main Content -->
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
            <h2 class="text-2xl font-bold text-white">Abstract Preview</h2>
            <p class="text-green-100 text-sm mt-2">Please preview the details of your abstract submission</p>
        </div>
        <form id="previewForm" action="{{ route('submit.preview') }}" method="POST">
            @csrf
            <div class="bg-gray-50 p-6 border border-gray-800">
                <!-- Header -->
                <h1 class="text-3xl font-bold text-gray-900 text-center mb-2">
                    {{ $article_title ?? 'Untitled' }}
                </h1>
                <div class="p-8">
                    <!-- Authors -->
                    <h1 class="text-1xl font-bold text-gray-900 text-center mb-2">
                        @if(isset($allAuthors) && is_array($allAuthors))
                            {{ implode(', ', array_map(fn($author) => $author['first_name'] . ' ' . ($author['middle_name'] ?? '') . ' ' . $author['surname'] . (isset($author['is_correspondent']) && $author['is_correspondent'] ? '*' : ''), $allAuthors)) }}
                        @endif
                    </h1>
                    
                    <!-- Universities -->
                    <h2 class="text-lg font-medium text-gray-700 text-center">
                        @if(isset($allAuthors) && is_array($allAuthors))
                            {{ implode(', ', array_map(fn($author) => $author['university'], $allAuthors)) }}
                        @endif
                    </h2>
                    
                    <!-- Departments -->
                    <h3 class="text-md text-gray-600 text-center">
                        @if(isset($allAuthors) && is_array($allAuthors))
                            {{ implode(', ', array_map(fn($author) => $author['department'], $allAuthors)) }}
                        @endif
                    </h3>
                </div>

                <!-- Abstract Section -->
                <div class="p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Abstract</h2>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $abstract['abstract'] ?? 'No abstract provided.' }}
                    </p>
                </div>

                <!-- Keywords Section -->
                <div class="p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Keywords</h2>
                    <p class="text-gray-700 leading-relaxed">{{ isset($abstract['keywords']) ? implode(', ', $abstract['keywords']) : 'No keywords provided.' }}</p>
                </div>

                <!-- Sub-Theme Section -->
                <div class="p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Sub-Theme</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $abstract['sub_theme'] ?? 'No sub-theme selected.' }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('user.step2') }}" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Previous
                </a>

                <button type="button" onclick="openModal()" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 flex items-center">
                    Continue
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <!-- Modal Content -->
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Ready for Submission</h3>
        </div>

        <!-- Important Notes -->
        <div class="space-y-4 border-t border-gray-200 pt-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-gray-800">Review Process</h4>
                    <p class="text-sm text-gray-600">Your abstract will be reviewed. You will be notified of the decision via email.</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-gray-800">Important Notice</h4>
                        <p class="text-sm text-gray-600">Once submitted, you cannot make changes to your abstract. Please ensure all details are correct.</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-gray-800">Next Steps</h4>
                    <p class="text-sm text-gray-600">After acceptance, you will be notified to submit your full article through the system.</p>
                </div>
            </div>
        </div>

        <!-- Modal Buttons -->
        <div class="mt-4 flex justify-end space-x-2">
            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                Cancel
            </button>
            <button type="submit" form="previewForm" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Confirm
            </button>
        </div>
    </div>
</div>

<script>
    function goBack() {
        window.history.back();
    }

    function openModal() {
        document.getElementById('confirmationModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
    }
</script>
@endsection
