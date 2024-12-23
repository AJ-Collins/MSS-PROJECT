@extends('user.layouts.user')

@section('user-content')
<!-- Progress Tracker -->
<div class="max-w-4xl mx-auto mb-8">
    <div class="relative">
        <!-- Progress Line -->
        <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
        <div class="absolute top-1/2 left-0 w-3/4 h-1 bg-green-500 -translate-y-1/2 transition-all duration-500"></div>

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

            <!-- Step 2: Active -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <span class="text-sm font-medium text-green-600">Abstract</span>
            </div>

            <!-- Step 3: Pending -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg ring-4 ring-green-100">
                    3
                </div>
                <span class="text-sm font-medium text-gray-500">Preview</span>
            </div>

            <!-- Step 4: Pending -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-semibold mb-2">
                    4
                </div>
                <span class="text-sm font-medium text-gray-500">Confirm</span>
            </div>
        </div>
    </div>
</div>
<!-- Main Content -->
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg overflow-hidden">
    <!-- Form Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
        <h2 class="text-2xl font-bold text-white">Abstract Preview</h2>
        <p class="text-green-100 text-sm mt-2">Please preview the details of your abstract submission</p>
    </div>
    <div class="bg-gray-50 p-6 border border-gray-800">
        <!-- Header -->
        <div class="p-8">
            <h1 class="text-3xl font-bold text-gray-900 text-center mb-2">System Testing Analysis</h1>
            <h2 class="text-lg font-medium text-gray-700 text-center">Collins Yegon AjKipz</h2>
            <h3 class="text-md text-gray-600 text-center">Hobbyist, ICI</h3>
        </div>

        <!-- Abstract Section -->
        <div class="p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Abstract</h2>
            <p class="text-gray-700 leading-relaxed">
                This project will concentrate on particular supporting points: the results of comparing the VRT method
                against traditional therapy, the critical components within the VRT that bring down anxiety, and the
                longitudinal effects on anxiety management and general well-being. Furthermore, individual traits like race,
                gender, and anxiety severity will be examined for their influence on treatment results. Although the study
                aims to investigate the practical implementation problems of VR, it will not pay much attention to the
                technical concerns of virtual reality development or the economic feasibility involved in adopting this
                technology, as these issues are out of the study's scope.
            </p>
        </div>

        <!-- Keywords Section -->
        <div class="p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Keywords</h2>
            <p class="text-gray-700 leading-relaxed">Best, Good, Good, Good, Good</p>
        </div>

        <!-- Sub-Theme Section -->
        <div class="p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Sub-Theme</h2>
            <p class="text-gray-700 leading-relaxed">Business and Entrepreneurship</p>
        </div>
    </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex justify-between items-center">
        <button type="button" onclick="goBack()" 
            class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
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

        <div class="flex space-x-4">
            <!-- PDF Button -->
            <a href="" 
                class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                PDF
            </a>

            <!-- Word Button -->
            <a href="" 
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Word
            </a>
        </div>

        <a href="{{route('reviewer.confirm')}}"
            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 flex items-center">
            Continue
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </a>
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none;
        }
        body {
            padding: 40px;
        }
        .container {
            max-width: none;
            padding: 0;
        }
    }
</style>

<script>
    function goBack() {
        window.history.back();
    }
</script>
@endsection
