@extends('user.layouts.user')

@section('user-content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Research Submissions Portal</h1>
    <p class="mt-2 text-sm text-gray-600">Choose your submission type to begin the application process</p>
</div>

<!-- Cards Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Conference Card -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400 transition-transform transform hover:scale-[1.02]">
        <div class="flex items-center justify-between mb-6">
            <div class="p-3 rounded-full bg-blue-100">
                <i data-lucide="book-open" class="h-8 w-8 text-blue-500"></i>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-medium bg-blue-50 text-blue-600">
                Open for Submissions
            </span>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-4">TUM 6TH MULTIDISCIPLINARY CONFERENCE</h2>
        <ul class="space-y-2 text-gray-600 mb-6">
            <li class="flex items-center">
                <i data-lucide="calendar" class="h-5 w-5 mr-3 text-blue-500"></i>
                Conference Date: June 15-17, 2024
            </li>
            <li class="flex items-center">
                <i data-lucide="users" class="h-5 w-5 mr-3 text-blue-500"></i>
                Expected Participants: 500+
            </li>
            <li class="flex items-center">
                <i data-lucide="trophy" class="h-5 w-5 mr-3 text-blue-500"></i>
                Best Paper Awards Available
            </li>
            <li class="flex items-center">
                <i data-lucide="globe" class="h-5 w-5 mr-3 text-blue-500"></i>
                International Participants
            </li>
        </ul>
        <a href="{{route('user.step1')}}"
            class="block w-full py-3 text-center text-white font-medium rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700">
            Submit Conference Paper
        </a>
    </div>

    <!-- Research Funding Card -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-400 transition-transform transform hover:scale-[1.02]">
        <div class="flex items-center justify-between mb-6">
            <div class="p-3 rounded-full bg-green-100">
                <i data-lucide="file-check" class="h-8 w-8 text-green-500"></i>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-medium bg-green-50 text-green-600">
                2024 Funding Cycle
            </span>
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-4">INTERNAL RESEARCH FUNDING FOR 2024</h2>
        <ul class="space-y-2 text-gray-600 mb-6">
            <li class="flex items-center">
                <i data-lucide="calendar" class="h-5 w-5 mr-3 text-green-500"></i>
                Submission Deadline: March 31, 2024
            </li>
            <li class="flex items-center">
                <i data-lucide="trophy" class="h-5 w-5 mr-3 text-green-500"></i>
                Funding up to $50,000
            </li>
            <li class="flex items-center">
                <i data-lucide="users" class="h-5 w-5 mr-3 text-green-500"></i>
                Open to All Departments
            </li>
            <li class="flex items-center">
                <i data-lucide="file-check" class="h-5 w-5 mr-3 text-green-500"></i>
                Multiple Grants Available
            </li>
        </ul>
        <a href=""
            class="block w-full py-3 text-center text-white font-medium rounded-lg bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700">
            Submit Funding Proposal
        </a>
    </div>
</div>

<!-- Help Section -->
<div class="text-center mt-8">
    <p class="text-sm text-gray-600">
        Need help? Contact our support team at 
        <a href="mailto:support@tum.ac.ke" class="text-blue-600 hover:text-blue-700">support@tum.ac.ke</a>
    </p>
</div>

<script>
    lucide.createIcons();
</script>
@endsection
