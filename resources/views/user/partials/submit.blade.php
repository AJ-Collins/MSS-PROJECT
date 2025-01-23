@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8 border-b pb-4">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center">
            <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Submissions Portal
        </h1>
        <p class="mt-2 text-sm text-gray-600">Please select the appropriate submission type and start submission.</p>
    </div>
    <!-- Submission Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        @forelse($submissionTypes as $type)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 text-xs font-semibold text-{{ $type->status === 'active' ? 'green' : 'red' }}-700 bg-{{ $type->status === 'active' ? 'green' : 'red' }}-100 rounded-full">
                        {{ $type->status === 'active' ? 'Open' : 'Closed' }}
                    </span>
                    <span class="text-sm text-gray-500">Deadline: {{ \Carbon\Carbon::parse($type->deadline)->format('M d, Y') }}</span>
                </div>
                
                <h2 class="text-xl font-bold text-gray-800 mb-3">{{ $type->title }}</h2>
                <p class="text-gray-600 text-sm mb-4">{{ $type->description }}</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Format: {{ $type->format }}
                    </div>
                </div>

                <a href="{{ $type->status === 'active' ? ($type->type === 'conference' ? route('user.step1') : route('user.step1_research')) : '#' }}"
                    class="block w-full py-3 px-4 text-center font-medium rounded-lg transition-colors duration-200 
                    {{ $type->status === 'active' 
                        ? ($type->type === 'conference' ? 'bg-blue-600 hover:bg-blue-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white')
                        : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                    {{ $type->status !== 'active' ? 'onclick="return false;" aria-disabled="true"' : '' }}>
                    Submit {{ $type->type === 'conference' ? 'Conference' : 'Research' }} Paper
                </a>
            </div>

            @if($type->guidelines)
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <h3 class="text-sm font-semibold text-gray-800 mb-2">Important Guidelines:</h3>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    @foreach(explode("\n", $type->guidelines) as $guideline)
                    <li>{{ $guideline }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        @empty
            <p class="mt-2 text-sm text-center text-gray-600">No submissions for ow. Will be available soon...</p>
        @endforelse

    </div>

    <!-- Help Section -->
    <div class="bg-gray-50 rounded-lg p-6 text-center border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Need Assistance?</h3>
        <p class="text-gray-600 mb-4">Our support team is here to help you with any questions or concerns.</p>
        <div class="flex justify-center space-x-4">
            <a href="mailto:support@tum.ac.ke" class="inline-flex items-center text-blue-600 hover:text-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                support@tum.ac.ke
            </a>
            <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                FAQs
            </a>
        </div>
    </div>
</div>

@endsection