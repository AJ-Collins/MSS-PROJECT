@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-semibold mb-4">
            Assessments for Document {{ $serial_number }}
        </h1>
        
        @if (isset($assessments) && $assessments->isNotEmpty())
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="text-left bg-gray-100">
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Reviewer</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Thematic Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Title Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Objectives Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Methodology Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Output Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Correction Type</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">General Comments</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assessments as $assessment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $assessment->reviewer ? $assessment->reviewer->first_name . ' ' . $assessment->reviewer->last_name : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->thematic_score }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->title_score }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->objectives_score }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->methodology_score }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->output_score }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if($assessment->correction_type)
                                    <span class="px-2 py-1 text-xs font-semibold {{ $assessment->correction_type == 'minor' ? 'bg-yellow-100 text-yellow-800' : ($assessment->correction_type == 'major' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($assessment->correction_type) }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->general_comments ?: 'No comments' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->total_score ?: 'No score' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <a href="{{ route('assessments.download-pdf', $assessment->abstract_submission_id) }}" 
                                    class="relative p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 group" 
                                    title="Download Assessment Form">
                                    <!-- Download Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M12 4v12m0 0l-4-4m4 4l4-4m0 8H8m8 0h4"/>
                                    </svg>
                                    <!-- Tooltip -->
                                    <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                         Download assessment
                                    </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif (isset($proposalAssessments) && $proposalAssessments->isNotEmpty())
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="text-left bg-gray-100">
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Reviewer</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Thematic Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Title Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Objectives Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Methodology Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Output Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Correction Type</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">General Comments</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Score</th>
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposalAssessments as $assessment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $assessment->reviewer ? $assessment->reviewer->first_name . ' ' . $assessment->reviewer->last_name : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->thematic_score }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->title_score }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->objectives_score }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->methodology_score }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->output_score }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if($assessment->correction_type)
                                    <span class="px-2 py-1 text-xs font-semibold {{ $assessment->correction_type == 'minor' ? 'bg-yellow-100 text-yellow-800' : ($assessment->correction_type == 'major' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($assessment->correction_type) }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->general_comments ?: 'No comments' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->total_score ?: 'No score' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <a href="{{ route('assessments.proposal.download-pdf', $assessment->abstract_submission_id) }}" 
                                        class="relative p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200 group" 
                                        title="Download Assessment Form">
                                        <!-- Download Icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M12 4v12m0 0l-4-4m4 4l4-4m0 8H8m8 0h4"/>
                                        </svg>
                                        <!-- Tooltip -->
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-900 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 mb-2 whitespace-nowrap z-10">
                                            Download assessment
                                        </span>
                                    </a>
                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="mt-4 text-gray-500">No assessments found for this document.</div>
        @endif
    </div>
@endsection
