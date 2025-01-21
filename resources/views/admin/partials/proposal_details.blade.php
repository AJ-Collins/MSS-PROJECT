@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.proposals') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back
        </a>
    </div>

    <!-- Document Header -->
    <div class="bg-white shadow overflow-hidden mb-6">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $researchSubmission->article_title }}</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Serial Number: {{ $researchSubmission->serial_number }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ 
                    $researchSubmission->score === null ? 'bg-yellow-300 text-gray-800' :
                    ($researchSubmission->score ? 'bg-green-300 text-gray-800' : 'bg-gray-300 text-gray-800') 
                }}">
                    {{ $researchSubmission->score === null ? 'Pending' : 
                        ($researchSubmission->score ? 'Completed' : 'Incomplete') }}
                </span>
            </div>
        </div>

        <!-- Document Details -->
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Submitted by</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $researchSubmission->user_reg_no }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Submission Date</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ date('F j, Y', strtotime($researchSubmission->created_at)) }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Score</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="{{ $researchSubmission->score === null ? 'bg-yellow-200 text-gray-800 p-2 rounded-md' : 'text-gray-900' }}">
                            {{ $researchSubmission->score ?? 'Not reviewed yet' }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Reviewers Section -->
    <div class="bg-white shadow overflow-hidden mb-6">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Assigned Reviewers</h3>
        </div>
        <div class="border-t border-gray-200">
            <ul class="divide-y divide-gray-200">
                @forelse($researchSubmission->reviewers as $reviewer)
                <li class="px-4 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $reviewer->first_name }} {{ $reviewer->last_name }}</p>
                            <p class="text-sm text-gray-500">{{ $reviewer->reg_no }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs {{ 
                            $reviewer->pivot->status === 'accepted' ? 'bg-green-300 text-grey-800' : 'bg-yellow-300 text-grey-800' 
                        }}">
                            {{ ucfirst($reviewer->pivot->status) }}
                        </span>
                    </div>
                </li>
                @empty
                <li class="px-4 py-4">
                    <p class="text-sm text-gray-700 bg-yellow-100 p-2 rounded-md">
                        No reviewers assigned yet
                    </p>
                </li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Document Preview -->
    <div class="bg-white shadow overflow-hidden">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Document Preview</h3>
            <div class="mt-4 flex space-x-4">
                @if( $researchSubmission->pdf_document_path )
                <a href="{{ asset('storage/' . $researchSubmission->pdf_document_path) }}" target="_blank" 
                   class="flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Article
                </a>
                @else
                    <p class="text-gray-500">Article not available.</p>
                @endif
                <a href="{{ route('proposal.abstract.download', ['serial_number' => $researchSubmission->serial_number]) }}" 
                   class="flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download(pdf)
                </a>
                <a href="{{ route('proposal.abstractWord.download', ['serial_number' => $researchSubmission->serial_number]) }}" 
                   class="flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download(word)
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any necessary JavaScript functionality here
});
</script>
@endsection