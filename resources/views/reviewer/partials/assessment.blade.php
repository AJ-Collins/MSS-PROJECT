@extends('reviewer.layouts.reviewer')

@section('reviewer-content')
<div class="min-h-screen bg-gray-50" x-data="{ 
    totalScore: 0,
    scores: {
        thematic: 0,
        title: 0,
        methodology: 0,
        output: 0,
        objectives: 0
    },
    zoomLevel: 100,
    correctionType: '',
    updateTotalScore() {
        this.totalScore = Object.values(this.scores).reduce((a, b) => a + b, 0);
    },
    zoomIn() {
        this.zoomLevel = Math.min(this.zoomLevel + 10, 200);
    },
    zoomOut() {
        this.zoomLevel = Math.max(this.zoomLevel - 10, 50);
    }
}">
    <!-- Main Content -->
    <div class="flex h-screen">
        <!-- Left Panel - Assessment Form -->
        <div class="w-1/2 h-full flex flex-col border-r border-gray-200 bg-white">
            <!-- Header -->
            <div class="flex-none bg-white border-b border-gray-200">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Document Assessment</h1>
                            <p class="mt-1 text-sm text-gray-500">Review and evaluate the abstract</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-sm text-gray-600">Total Score:</div>
                            <div class="px-3 py-1 bg-blue-50 rounded-lg">
                                <span x-text="totalScore" class="text-xl font-bold text-blue-600"></span>
                                <span class="text-blue-600">/50</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scrollable Form Content -->
            <div class="flex-1 overflow-y-auto">
            <form 
            @submit="handleSubmit"
            action="{{ route('reviewer.abstracts.assessment.store', $submission->serial_number) }}" 
                    method="POST" 
                    class="p-6 space-y-6">
                    @csrf
                    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Please check the following errors:</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
        {{ session('success') }}
    </div>
@endif
                    <!-- Assessment Sections -->
                    <div class="space-y-6">
                        <!-- Research Thematic Area -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <label class="block text-base font-semibold text-gray-900">
                                            Research Thematic Area <span class="text-red-500"> (Out of 5)</span>
                                        </label>
                                        <textarea 
                                            name="thematic_comments" 
                                            placeholder="Provide comments on the research thematic area..." 
                                            class="mt-4 w-full h-20 min-h-[120px] rounded-lg border border-gray-800 bg-gray-100 focus:border-blue-500 focus:ring-blue-500" 
                                            required
                                        ></textarea>
                                    </div>
                                    <div class="flex-none">
                                        <div class="w-32 text-center p-3 bg-gray-50 rounded-lg border border-gray-800">
                                            <label class="block text-sm font-medium text-gray-700">Score</label>
                                            <input 
                                                type="number" 
                                                name="thematic_score"
                                                class="mt-2 w-20 text-center text-lg font-bold rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                                min="0" 
                                                max="5"
                                                required
                                            >
                                            <div class="mt-1 text-xs text-gray-800">Out of 5</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Research Title -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <label class="block text-base font-semibold text-gray-900">
                                            Research Title <span class="text-red-500"> (Out of 5)</span>
                                        </label>
                                        <textarea 
                                            name="title_comments" 
                                            placeholder="Provide comments on the research title..." 
                                            class="mt-4 w-full h-20 min-h-[120px] rounded-lg border border-gray-800 bg-gray-100 focus:border-blue-500 focus:ring-blue-500" 
                                            required
                                        ></textarea>
                                    </div>
                                    <div class="flex-none">
                                        <div class="w-32 text-center p-3 bg-gray-50 rounded-lg border border-gray-800">
                                            <label class="block text-sm font-medium text-gray-700">Score</label>
                                            <input 
                                                type="number" 
                                                name="title_score"
                                                class="mt-2 w-20 text-center text-lg font-bold rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                                min="0" 
                                                max="5"
                                                required
                                            >
                                            <div class="mt-1 text-xs text-gray-800">Out of 5</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Objectives/Aims -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <label class="block text-base font-semibold text-gray-900">
                                            Objective(s)/ Aims <span class="text-red-500"> (Out of 5)</span>
                                        </label>
                                        <textarea 
                                            name="objectives_comments" 
                                            placeholder="Provide comments on the objectives/aims..." 
                                            class="mt-4 w-full h-20 min-h-[120px] rounded-lg border border-gray-800 bg-gray-100 focus:border-blue-500 focus:ring-blue-500" 
                                            required
                                        ></textarea>
                                    </div>
                                    <div class="flex-none">
                                        <div class="w-32 text-center p-3 bg-gray-50 rounded-lg border border-gray-800">
                                            <label class="block text-sm font-medium text-gray-700">Score</label>
                                            <input 
                                                type="number" 
                                                name="objectives_score"
                                                class="mt-2 w-20 text-center text-lg font-bold rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                                min="0" 
                                                max="5"
                                                required
                                            >
                                            <div class="mt-1 text-xs text-gray-800">Out of 5</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Methodology -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <label class="block text-base font-semibold text-gray-900">
                                            Methodology <span class="text-red-500"> (Out of 30)</span>
                                        </label>
                                        <textarea 
                                            name="methodology_comments" 
                                            placeholder="Provide comments on the methodology..." 
                                            class="mt-4 w-full h-20 min-h-[120px] rounded-lg border border-gray-800 bg-gray-100 focus:border-blue-500 focus:ring-blue-500" 
                                            required
                                        ></textarea>
                                    </div>
                                    <div class="flex-none">
                                        <div class="w-32 text-center p-3 bg-gray-50 rounded-lg border border-gray-800">
                                            <label class="block text-sm font-medium text-gray-700">Score</label>
                                            <input 
                                                type="number" 
                                                name="methodology_score"
                                                class="mt-2 w-20 text-center text-lg font-bold rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                                min="0" 
                                                max="30"
                                                required
                                            >
                                            <div class="mt-1 text-xs text-gray-800">Out of 30</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expected Output -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <label class="block text-base font-semibold text-gray-900">
                                            Expected Output <span class="text-red-500"> (Out of 5)</span>
                                        </label>
                                        <textarea 
                                            name="output_comments" 
                                            placeholder="Provide comments on the expected output..." 
                                            class="mt-4 w-full h-20 min-h-[120px] rounded-lg border border-gray-800 bg-gray-100 focus:border-blue-500 focus:ring-blue-500" 
                                            required
                                        ></textarea>
                                    </div>
                                    <div class="flex-none">
                                        <div class="w-32 text-center p-3 bg-gray-50 rounded-lg border border-gray-800">
                                            <label class="block text-sm font-medium text-gray-700">Score</label>
                                            <input 
                                                type="number" 
                                                name="output_score"
                                                class="mt-2 w-20 text-center text-lg font-bold rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                                min="0" 
                                                max="5"
                                                required
                                            >
                                            <div class="mt-1 text-xs text-gray-800">Out of 5</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Assessment Decision -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div class="p-6 space-y-6">
                                <!-- General Comments -->
                                <div>
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900">General Comments</h3>
                                            <p class="mt-1 text-sm text-gray-500">Provide your overall assessment of the research proposal</p>
                                        </div>
                                    </div>
                                    <textarea 
                                        name="general_comments" 
                                        class="w-full min-h-[120px] rounded-lg border border-gray-800 bg-gray-100 h-20 focus:border-blue-500 focus:ring-blue-500" 
                                        placeholder="Enter your general comments and observations..."
                                        required
                                    ></textarea>
                                </div>

                                <!-- Assessment Type -->
                                <div>
                                    <div class="mb-4">
                                        <h3 class="text-base font-semibold text-gray-900">Assessment Decision</h3>
                                        <p class="mt-1 text-sm text-gray-500">Select the type of corrections needed</p>
                                    </div>

                                    <div class="space-y-4" x-data="{ selectedType: null }">
                                        <!-- Minor Corrections -->
                                        <div class="rounded-lg border border-gray-200 overflow-hidden">
                                            <label class="flex items-center p-4 cursor-pointer hover:bg-gray-50"
                                                :class="{ 'bg-blue-50 border-blue-200': selectedType === 'minor' }">
                                                <input 
                                                    type="radio" 
                                                    name="correction_type" 
                                                    value="minor"
                                                    x-model="selectedType"
                                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                                    required
                                                >
                                                <div class="ml-3">
                                                    <div class="font-medium text-gray-900">Minor Corrections</div>
                                                    <div class="text-sm text-gray-500">Small changes or clarifications needed</div>
                                                </div>
                                            </label>
                                            <div x-show="selectedType === 'minor'" 
                                                x-collapse 
                                                class="border-t border-gray-200 p-4 bg-white">
                                                <textarea 
                                                    name="correction_comments" 
                                                    class="w-full min-h-[100px] rounded-lg border border-gray-800 bg-gray-100 h-20 focus:border-blue-500 focus:ring-blue-500" 
                                                    placeholder="Describe the minor corrections needed..."
                                                ></textarea>
                                            </div>
                                        </div>

                                        <!-- Major Corrections -->
                                        <div class="rounded-lg border border-gray-200 overflow-hidden">
                                            <label class="flex items-center p-4 cursor-pointer hover:bg-gray-50"
                                                :class="{ 'bg-blue-50 border-blue-200': selectedType === 'major' }">
                                                <input 
                                                    type="radio" 
                                                    name="correction_type" 
                                                    value="major"
                                                    x-model="selectedType"
                                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                                    required
                                                >
                                                <div class="ml-3">
                                                    <div class="font-medium text-gray-900">Major Corrections</div>
                                                    <div class="text-sm text-gray-500">Significant revisions or rework needed</div>
                                                </div>
                                            </label>
                                            <div x-show="selectedType === 'major'" 
                                                x-collapse 
                                                class="border-t border-gray-200 p-4 bg-white">
                                                <textarea 
                                                    name="correction_comments" 
                                                    class="w-full min-h-[100px] rounded-lg border border-gray-800 bg-gray-100 h-20 focus:border-blue-500 focus:ring-blue-500" 
                                                    placeholder="Describe the major corrections needed..."
                                                ></textarea>
                                            </div>
                                        </div>

                                        <!-- Reject -->
                                        <div class="rounded-lg border border-gray-200 overflow-hidden">
                                            <label class="flex items-center p-4 cursor-pointer hover:bg-gray-50"
                                                :class="{ 'bg-blue-50 border-blue-200': selectedType === 'reject' }">
                                                <input 
                                                    type="radio" 
                                                    name="correction_type" 
                                                    value="reject"
                                                    x-model="selectedType"
                                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                                    required
                                                >
                                                <div class="ml-3">
                                                    <div class="font-medium text-gray-900">Reject</div>
                                                    <div class="text-sm text-gray-500">The proposal is not suitable for submission</div>
                                                </div>
                                            </label>
                                            <div x-show="selectedType === 'reject'" 
                                                x-collapse 
                                                class="border-t border-gray-200 p-4 bg-white">
                                                <textarea 
                                                    name="correction_comments" 
                                                    class="w-full min-h-[100px] rounded-lg border border-gray-800 bg-gray-100 h-20 focus:border-blue-500 focus:ring-blue-500" 
                                                    placeholder="Provide comments explaining the rejection..."
                                                ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-right">
                        <button 
                            type="submit" 
                            class="inline-flex justify-center py-3 px-6 text-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Submit Assessment
                        </button>
                    </div>
                </form>

            </div>            
        </div>

        <!-- Right Panel - Document Preview -->
        <div class="w-1/2 h-full flex flex-col bg-gray-50">
            <!-- Header -->
            <div class="flex-none bg-white border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Document Preview</h2>
                        <p class="mt-1 text-sm text-gray-500">Aricle Abstract</p>
                    </div>        
                </div>
            </div>

            <!-- Document Viewer -->
            <div 
                x-data="documentPreview('{{ route('reviewer.assessment.abstractpreview', $serial_number) }}')" 
                x-init="loadAbstract()"
                class="flex-1 overflow-y-auto p-6"
            >
                <!-- Loading State -->
                <div x-show="loading" class="flex justify-center items-center h-full">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                </div>

                <!-- Content -->
                <div x-show="!loading && abstract" class="max-w-3xl mx-auto bg-white shadow p-8">
                    <h1 x-text="abstract.title" class="text-2xl font-bold text-center text-gray-900 mb-6"></h1>
                    
                    <div class="mb-8 text-center">
                        <div class="space-y-1">
                            <template x-for="(author, index) in [...new Set(abstract.authors.map(a => JSON.stringify(a)))].map(a => JSON.parse(a))" :key="index">
                                <p class="text-sm text-gray-700" x-text="[author.first_name, author.middle_name, author.surname].filter(Boolean).join(' ')"></p>
                            </template>
                        </div>
                    </div>

                    <h2 class="text-lg font-bold text-gray-900 mb-4">ABSTRACT</h2>
                    <p x-text="abstract.content" class="text-gray-700 leading-relaxed text-justify mb-6"></p>

                    <div class="space-y-4">
                        <div>
                            <h3 class="font-bold text-gray-900">Keywords</h3>
                            <p x-text="abstract.keywords || 'Not available'" class="text-gray-700"></p>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Sub-Theme</h3>
                            <p x-text="abstract.sub_theme || 'Not available'" class="text-gray-700"></p>
                        </div>
                    </div>
                </div>

                <!-- Error State -->
                <div x-show="!loading && !abstract" class="flex justify-center items-center h-full">
                    <p class="text-red-600">Failed to load abstract</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function documentPreview(apiUrl) {
    return {
        abstract: null,
        loading: true,
        async loadAbstract() {
            try {
                const response = await fetch(apiUrl);
                const data = await response.json();
                this.abstract = response.ok ? data : null;
            } catch (error) {
                console.error('Error:', error);
                this.abstract = null;
            } finally {
                this.loading = false;
            }
        }
    };
}
</script>

@endsection