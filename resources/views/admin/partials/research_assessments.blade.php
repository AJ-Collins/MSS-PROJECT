@extends('admin.layouts.admin')

@section('admin-content')
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
                        <th class="px-6 py-4 text-sm font-medium text-gray-600">Total Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assessments as $assessment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $assessment->reviewer ? $assessment->reviewer->name : 'N/A' }}
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposalAssessments as $assessment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $assessment->reviewer ? $assessment->reviewer->name : 'N/A' }}
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
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $assessment->total_score }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="mt-4 text-gray-500">No assessments found for this document.</div>
        @endif
    </div>
@endsection
