@extends('user.layouts.user')

@section('user-content')
<!-- Progress Tracker -->
<div class="max-w-4xl mx-auto mb-8">
    <div class="relative">
        <!-- Progress Line -->
        <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
        <div class="absolute top-1/2 left-0 w-full h-1 bg-green-500 -translate-y-1/2 transition-all duration-500"></div>

        <!-- Steps -->
        <div class="relative flex justify-between">
            <!-- Step 1: Complete -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-green-600">Authors</span>
            </div>

            <!-- Step 2: Complete -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-green-600">Abstract</span>
            </div>

            <!-- Step 3: Complete -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-green-600">Preview</span>
            </div>

            <!-- Step 4: Active -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg ring-4 ring-green-100">
                    4
                </div>
                <span class="text-sm font-medium text-green-600">Confirm</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
            <h2 class="text-2xl font-bold text-white">Confirm Submission</h2>
            <p class="text-green-100 text-sm mt-2">Please review your submission details carefully before confirming</p>
        </div>
        @if (session('success'))
            <div class="bg-green-100 border border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif
        <form method="" action="" class="p-8">
            @csrf
            
            <!-- Confirmation Card -->
            <div class="bg-gray-50 border border-gray-800 p-6 mb-8">
                <div class="grid gap-6">
                    <!-- Status Icon -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Ready for Submission</h3>
                        <p class="text-gray-600">Your abstract has been prepared and is ready for final submission</p>
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
                                <p class="text-sm text-gray-600">After acceptance, you will be invited to submit your full article through the system.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between space-x-4">
                <button type="button" onclick="window.history.back()" 
                    class="flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Previous
                </button>
                <!-- Dropdown for "Go to Step" -->
                <div class="relative">
                    <select id="stepNavigation" class="block w-full px-4 py-2 pr-8 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <option value="1">Go to Step 1: Authors</option>
                        <option value="2">Go to Step 2: Abstract</option>
                        <option value="3">Go to Step 3: Preview</option>
                        <option value="4" selected>Step 4: Confirm</option>
                    </select>
                </div>
                <button type="" 
                    class="flex items-center px-8 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-300">
                    Confirm Submission
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Help Text -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-500">
            Need assistance? Contact our support team at 
            <a href="mailto:support@example.com" class="text-green-600 hover:text-green-700">support@example.com</a>
        </p>
    </div>
</div>

<style>
.bg-gradient-to-r {
    background-size: 200% 100%;
    animation: gradient 15s ease infinite;
}

@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

button {
    transition: all 0.3s ease;
}

button:active {
    transform: scale(0.98);
}
</style>
@if (session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif
@endsection