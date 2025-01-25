@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-7xl">
        <div class="bg-white shadow-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">
                    Assessments for Document {{ $serial_number }}
                </h1>
            </div>

            @if (isset($assessments) && $assessments->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Thematic</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Objectives</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Methodology</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Output</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correction</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Comments</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($assessments as $assessment)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $assessment->reviewer ? $assessment->reviewer->first_name . ' ' . $assessment->reviewer->last_name : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                        <span class="text-sm text-gray-500">{{ $assessment->thematic_score }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                        <span class="text-sm text-gray-500">{{ $assessment->title_score }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                        <span class="text-sm text-gray-500">{{ $assessment->objectives_score }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                        <span class="text-sm text-gray-500">{{ $assessment->methodology_score }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                        <span class="text-sm text-gray-500">{{ $assessment->output_score }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($assessment->correction_type)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $assessment->correction_type == 'minor' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($assessment->correction_type == 'major' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($assessment->correction_type) }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 text-xs">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell text-sm text-gray-500">
                                        {{ Str::limit($assessment->general_comments, 20, '...') ?: 'No comments' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $assessment->total_score ?: 'No score' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('assessments.download-pdf', $assessment->abstract_submission_id) }}" 
                                           class="text-blue-600 hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full p-2 transition duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M12 4v12m0 0l-4-4m4 4l4-4m0 8H8m8 0h4"/>
                                            </svg>
                                            <span class="sr-only">Download Assessment</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        {{-- Mobile Pagination --}}
                        {{ $assessments->links('vendor.pagination.simple-tailwind') }}
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ $assessments->firstItem() }}</span>
                                to
                                <span class="font-medium">{{ $assessments->lastItem() }}</span>
                                of
                                <span class="font-medium">{{ $assessments->total() }}</span>
                                results
                            </p>
                        </div>
                        <div>
                            {{ $assessments->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>

            @elseif (isset($proposalAssessments) && $proposalAssessments->isNotEmpty())
            <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Thematic</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Title</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Objectives</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Methodology</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Output</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correction</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Comments</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($proposalAssessments as $proposalAssessment)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $proposalAssessment->reviewer ? $proposalAssessment->reviewer->first_name . ' ' . $proposalAssessment->reviewer->last_name : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                        <span class="text-sm text-gray-500">{{ $proposalAssessment->thematic_score }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell">
                                        <span class="text-sm text-gray-500">{{ $proposalAssessment->title_score }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                        <span class="text-sm text-gray-500">{{ $proposalAssessment->objectives_score }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                        <span class="text-sm text-gray-500">{{ $proposalAssessment->methodology_score }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden lg:table-cell">
                                        <span class="text-sm text-gray-500">{{ $proposalAssessment->output_score }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if($proposalAssessment->correction_type)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $proposalAssessment->correction_type == 'minor' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($proposalAssessment->correction_type == 'major' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ ucfirst($proposalAssessment->correction_type) }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 text-xs">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap hidden md:table-cell text-sm text-gray-500">
                                        {{ Str::limit($proposalAssessment->general_comments, 20, '...') ?: 'No comments' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $proposalAssessment->total_score ?: 'No score' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('assessments.proposal.download-pdf', $proposalAssessment->abstract_submission_id) }}" 
                                           class="text-blue-600 hover:text-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full p-2 transition duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                    d="M12 4v12m0 0l-4-4m4 4l4-4m0 8H8m8 0h4"/>
                                            </svg>
                                            <span class="sr-only">Download Assessment</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        {{-- Mobile Pagination --}}
                        {{ $proposalAssessments->links('vendor.pagination.simple-tailwind') }}
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ $proposalAssessments->firstItem() }}</span>
                                to
                                <span class="font-medium">{{ $proposalAssessments->lastItem() }}</span>
                                of
                                <span class="font-medium">{{ $proposalAssessments->total() }}</span>
                                results
                            </p>
                        </div>
                        <div>
                            {{ $proposalAssessments->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="px-6 py-4 text-center text-gray-500">
                    <p class="text-lg">No assessments found for this document.</p>
                    <p class="text-sm text-gray-400 mt-2">There are currently no assessments available.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom scrollbar for table */
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: rgba(0,0,0,0.2) transparent;
        }
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.2);
            border-radius: 4px;
        }
    </style>
@endpush