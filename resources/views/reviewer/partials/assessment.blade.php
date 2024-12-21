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
                <form @submit.prevent="// Handle form submission" class="p-6 space-y-6">
                    <!-- Assessment Sections -->
                    <div class="space-y-6">
                        <!-- Research Thematic Area -->
                        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <label class="block text-base font-semibold text-gray-900">
                                            Research Thematic Area<span class="text-red-500"> (Out of 5)</span>
                                        </label>
                                        <textarea 
                                            name="thematic_area"
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
                                                x-model="scores.title"
                                                @input="updateTotalScore"
                                                class="mt-2 w-20 text-center text-lg font-bold rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                                min="0" 
                                                max="5"
                                                required
                                            >
                                            <div class="mt-1 text-xs text-gray-800">Out of 5</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <label class="block text-base font-semibold text-gray-900">
                                            Research Title <span class="text-red-500"> (Out of 5)</span>
                                        </label>
                                        <textarea 
                                            name="thematic_area"
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
                                                x-model="scores.methodology"
                                                @input="updateTotalScore"
                                                class="mt-2 w-20 text-center text-lg font-bold rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                                min="0" 
                                                max="5"
                                                required
                                            >
                                            <div class="mt-1 text-xs text-gray-800">Out of 5</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <label class="block text-base font-semibold text-gray-900">
                                            Objective(s)/ Aims <span class="text-red-500"> (Out of 5)</span>
                                        </label>
                                        <p class="mt-1 text-sm text-gray-500">Evaluate the research focus and alignment</p>
                                        <textarea 
                                            name="thematic_area"
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
                                                x-model="scores.output"
                                                @input="updateTotalScore"
                                                class="mt-2 w-20 text-center text-lg font-bold rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                                min="0" 
                                                max="5"
                                                required
                                            >
                                            <div class="mt-1 text-xs text-gray-800">Out of 5</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <label class="block text-base font-semibold text-gray-900">
                                            Methodology <span class="text-red-500"> (Out of 30)</span>
                                        </label>
                                        <p class="mt-1 text-sm text-gray-500">Evaluate the research focus and alignment</p>
                                        <textarea 
                                            name="thematic_area"
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
                                                x-model="scores.objectives"
                                                @input="updateTotalScore"
                                                class="mt-2 w-20 text-center text-lg font-bold rounded-md border border-gray-300 focus:border-blue-500 focus:ring-blue-500" 
                                                min="0" 
                                                max="30"
                                                required
                                            >
                                            <div class="mt-1 text-xs text-gray-800">Out of 5</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <label class="block text-base font-semibold text-gray-900">
                                            Expected Output <span class="text-red-500"> (Out of 5)</span>
                                        </label>
                                        <p class="mt-1 text-sm text-gray-500">Evaluate the research focus and alignment</p>
                                        <textarea 
                                            name="thematic_area"
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
                                                x-model="scores.thematic"
                                                @input="updateTotalScore"
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
                            name="minor_corrections" 
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
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                        >
                        <div class="ml-3">
                            <div class="font-medium text-gray-900">Major Corrections</div>
                            <div class="text-sm text-gray-500">Significant revisions required</div>
                        </div>
                    </label>
                    <div x-show="selectedType === 'major'" 
                         x-collapse 
                         class="border-t border-gray-200 p-4 bg-white">
                        <textarea 
                            name="major_corrections" 
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
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                        >
                        <div class="ml-3">
                            <div class="font-medium text-gray-900">Reject</div>
                            <div class="text-sm text-gray-500">Research proposal does not meet requirements</div>
                        </div>
                    </label>
                    <div x-show="selectedType === 'reject'" 
                         x-collapse 
                         class="border-t border-gray-200 p-4 bg-white">
                        <textarea 
                            name="reject_reasons" 
                            class="w-full min-h-[100px] rounded-lg border border-gray-800 bg-gray-100 h-20 focus:border-blue-500 focus:ring-blue-500" 
                            placeholder="Provide detailed reasons for rejection..."
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    </div>
                </form>
            </div>

            <!-- Sticky Footer -->
            <div class="flex-none bg-white border-t border-gray-200 p-6">
                <div class="flex items-center justify-between gap-4">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Save Draft
                    </button>
                    <button type="submit" class="px-8 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Submit Assessment
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Panel - Document Preview -->
        <div class="w-1/2 h-full flex flex-col bg-gray-50">
            <!-- Header -->
            <div class="flex-none bg-white border-b border-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Document Preview</h2>
                        <p class="mt-1 text-sm text-gray-500">Research Proposal Document</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600" x-text="`${zoomLevel}%`"></span>
                        <button @click="zoomOut" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg" title="Zoom Out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                            </svg>
                        </button>
                        <button @click="zoomIn" class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg" title="Zoom In">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                        <button class="p-2 text-gray-500 hover:bg-gray-100 rounded-lg" title="Download">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Document Viewer -->
            <div class="flex-1 overflow-y-auto p-6">
                <div 
                    class="bg-white rounded-xl shadow-sm h-full border border-gray-200"
                    :style="`transform: scale(${zoomLevel/100}); transform-origin: top left;`"
                >
                    <div class="h-full flex items-center justify-center border-2 border-dashed border-gray-200 rounded-xl p-8">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Document Preview</h3>
                            <p class="mt-1 text-sm text-gray-500">PDF, DOCX, or other document formats</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection