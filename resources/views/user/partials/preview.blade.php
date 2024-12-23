@extends('user.layouts.user')

@section('user-content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
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

    <!-- Action Buttons -->
    <div class="mt-8 flex justify-between items-center">
        <button type="button" onclick="goBack()" 
            class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Previous
        </button>

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

        <button type="submit" form="previewForm" name="submit_type" value="save"
            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 flex items-center">
            Continue
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </button>
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
