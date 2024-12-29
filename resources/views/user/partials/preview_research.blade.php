@extends('user.layouts.user')

@section('user-content')
<div class="container mx-auto px-4 py-8">
    <!-- Progress Tracker -->
    <div class="max-w-4xl mx-auto mb-8">
        <div class="relative">
            <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
            <div class="absolute top-1/2 left-0 w-3/4 h-1 bg-green-500 -translate-y-1/2 transition-all duration-500"></div>

            <div class="relative flex justify-between">
                @foreach(['Authors', 'Abstract', 'Preview', 'Confirm'] as $index => $step)
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 {{ $index < 2 ? 'bg-green-500' : ($index == 2 ? 'bg-green-500 ring-4 ring-green-100' : 'bg-gray-200') }} 
                            rounded-full flex items-center justify-center {{ $index < 3 ? 'text-white' : 'text-gray-600' }} font-semibold mb-2 {{ $index < 2 ? 'shadow-lg' : '' }}">
                            @if($index < 2)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        <span class="text-sm font-medium {{ $index < 3 ? 'text-green-600' : 'text-gray-500' }}">{{ $step }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto">
        <form 
            action="{{route('submit.preview_research')}}"
            enctype="multipart/form-data"
            method="POST">
            @csrf
            <div class="bg-white shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white">Preview Submission</h2>
                    <p class="text-green-100 text-sm mt-2">Review your submission details before proceeding.</p>
                </div>

                <div class="flex flex-col lg:flex-row">
                    <div class="w-full lg:w-1/2 p-6 border border-gray-800">
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Article Details</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="space-y-4">
                                    <div class="p-8">
                                        <h1 class="text-3xl font-bold text-gray-900 text-center mb-2">
                                            {{ $authorData['first_name'] ?? '' }} {{ $authorData['middle_name'] ?? '' }} {{ $authorData['surname'] ?? '' }}
                                        </h1>
                                        <h2 class="text-lg font-medium text-gray-700 text-center">{{ $authorData['university'] ?? '' }}</h2>
                                        <h3 class="text-md text-gray-600 text-center">{{ $authorData['department'] ?? '' }}</h3>
                                    </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Title</h4>
                                            <p class="mt-1 text-base text-gray-900">{{ $articleTitle }}</p>
                                            <input type="hidden" name="article_title" value="{{ $articleTitle }}">
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Sub-Theme</h4>
                                            <p class="mt-1 text-base text-gray-900">{{ $subTheme }}</p>
                                            <input type="hidden" name="sub_theme" value="{{ $subTheme }}">
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Keywords</h4>
                                            <div class="mt-1 flex flex-wrap gap-2">
                                                @if(is_array($keywords) && count($keywords) > 0)
                                                    {{ implode(', ', $keywords) }}
                                                @else
                                                    No keywords provided
                                                @endif
                                                @foreach($keywords as $keyword)
                                                    <input type="hidden" name="keywords[]" value="{{ $keyword }}">
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Abstract</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="prose max-w-none">
                                        {{ $abstract }}
                                    </div>
                                    <div class="mt-4 text-sm text-gray-500">
                                        Word count: {{ str_word_count($abstract) }}
                                    </div>
                                    <input type="hidden" name="abstract" value="{{ $abstract }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/2 p-6 border border-gray-800">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Document Preview</h3>
                        <div class="bg-gray-50 rounded-lg h-[calc(100vh-400px)] min-h-[500px]">
                            @if($documentPath)
                                @if(pathinfo($documentPath, PATHINFO_EXTENSION) === 'pdf')
                                    <embed src="{{ asset($documentPath) }}"
                                           type="application/pdf"
                                           class="w-full h-full rounded-lg">
                                @else
                                    <div class="flex flex-col items-center justify-center h-full p-6">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
                                        </svg>
                                        <p class="text-gray-900 font-medium mb-2">{{ basename($documentPath) }}</p>
                                        <a href="{{ asset($documentPath) }}"
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Open Document
                                        </a>
                                    </div>
                                @endif
                                <input type="hidden" name="document_path" value="{{ $documentPath }}">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <p class="text-gray-500">No document uploaded</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('user.step2_research') }}" 
                           class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400">
                            Previous
                        </a>
                        <div class="relative">
                            <select id="stepNavigation" class="block w-full px-4 py-2 pr-8 text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                                <option value="1">Go to Step 1: Authors</option>
                                <option value="2">Go to Step 2: Abstract</option>
                                <option value="3">Go to Step 3: Preview</option>
                                <option value="4" selected>Step 4: Confirm</option>
                            </select>
                        </div>
                        <button type="submit" 
                           class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
