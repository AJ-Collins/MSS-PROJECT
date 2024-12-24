@extends('user.layouts.user')

@section('user-content')
<div class="container mx-auto px-4 py-8">
    <!-- Progress Tracker -->
    <div class="max-w-4xl mx-auto mb-8">
        <div class="relative">
            <!-- Progress Line -->
            <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
            <div class="absolute top-1/2 left-0 w-1/2 h-1 bg-green-500 -translate-y-1/2 transition-all duration-500"></div>

            <!-- Steps -->
            <div class="relative flex justify-between">
                <!-- Step 1: Complete -->
                <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span class="text-sm font-medium text-green-600">Authors</span>
            </div>

                <!-- Step 2: Active -->
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg ring-4 ring-green-100">
                        2
                    </div>
                    <span class="text-sm font-medium text-green-600">Abstract</span>
                </div>

                <!-- Step 3: Pending -->
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-semibold mb-2">
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

    <!-- Main Content Section -->
    <div class="max-w-4xl mx-auto">
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                <h2 class="text-2xl font-bold text-white">Abstract Submission</h2>
                <p class="text-green-100 text-sm mt-2">Please fill in the details of your abstract submission.</p>
            </div>

            <!-- Form Section -->
            <form 
                id="step2Form" 
                method="POST" 
                action="{{route('submit.step2_research')}}" 
                enctype="multipart/form-data" 
                class="p-8">
                @csrf
                <input type="hidden" name="submission_type" value="abstract">
            <div class="bg-gray-50 p-6 border border-gray-800">
                <!-- Title Input -->
                <div class="mb-6">
                    <label for="article-title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" id="article-title" name="article_title" 
                           class="w-full px-4 py-2 border border-gray-800 rounded-md focus:ring-green-500 focus:border-green-500"
                           placeholder="Enter the title of your article"
                           value="{{ old('article_title') }}" required>
                </div>

                <!-- Sub-Theme Selection -->
                <div class="mb-6">
                    <label for="sub-theme" class="block text-sm font-medium text-gray-700 mb-1">Sub-Theme</label>
                    <select id="sub-theme" name="sub_theme" 
                            class="w-full px-4 py-2 border border-gray-800 rounded-md focus:ring-green-500 focus:border-green-500" required>
                        <option value="">Select a sub-theme</option>
                        <option value="Transformative Education">Transformative Education</option>
                        <option value="Business and Entrepreneurship">Business and Entrepreneurship</option>
                        <option value="Health and Food Security">Health and Food Security</option>
                        <option value="Digital, Creative Economy and Contemporary Societies">Digital, Creative Economy and Contemporary Societies</option>
                        <option value="Engineering, Technology and Sustainable Environment">Engineering, Technology and Sustainable Environment</option>
                        <option value="Blue Economy & Maritime Affairs">Blue Economy & Maritime Affairs</option>
                    </select>
                </div>

                <!-- Abstract Input -->
                <div class="mb-6">
                    <label for="abstract" class="block text-sm font-medium text-gray-700 mb-1">Abstract (maximum 500 words)</label>
                    <div id="abstract" contenteditable="true" 
                         class="w-full px-4 py-2 border border-gray-800 rounded-md min-h-[200px] focus:ring-green-500 focus:border-green-500 bg-white"
                         placeholder="Enter your abstract"></div>
                    <input type="hidden" name="abstract" id="hiddenAbstract">
                    <p id="wordCount" class="text-sm text-gray-500 mt-2">Word Count: 0/500</p>
                </div>

                <!-- Keywords -->
<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Keywords (3-5 keywords)</label>
    <div id="keywords-container" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="relative">
            <input type="text" name="keywords[]" placeholder="Keyword 1" 
                   class="w-full px-4 py-2 border border-gray-800 rounded-md focus:ring-green-500 focus:border-green-500">
        </div>
        <div class="relative">
            <input type="text" name="keywords[]" placeholder="Keyword 2" 
                   class="w-full px-4 py-2 border border-gray-800 rounded-md focus:ring-green-500 focus:border-green-500">
        </div>
        <div class="relative">
            <input type="text" name="keywords[]" placeholder="Keyword 3" 
                   class="w-full px-4 py-2 border border-gray-800 rounded-md focus:ring-green-500 focus:border-green-500">
        </div>
    </div>
    <button type="button" id="add-keyword" 
            class="mt-4 px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
        Add Keyword
    </button>
    <p id="max-keyword-message" class="text-sm text-red-500 mt-2 hidden">You have reached the maximum of 5 keywords.</p>
</div>

                <!-- File Upload -->
                <div class="mb-8">
                    <label for="file-upload" class="block text-sm font-medium text-gray-700 mb-1">
                        Upload Research Proposal <span class="text-red-500">(PDF or Word format, max 100MB)</span>
                    </label>
                    <div class="mt-2">
                        <input type="file" id="file-upload" name="pdf_document" 
                            accept=".pdf,.doc,.docx"
                            required 
                            onchange="handleFileUpload(event)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Accepted formats: PDF (.pdf), Word (.doc, .docx)</p>
                    <div id="file-preview" class="hidden mt-4 p-4 bg-gray-50 rounded-md">
                        <p class="text-sm text-gray-600">Selected file: <span id="file-name" class="font-medium"></span></p>
                        <button type="button" onclick="deleteFile()" 
                            class="mt-2 px-3 py-1 text-sm text-red-600 hover:text-red-700 focus:outline-none">
                            Remove file
                        </button>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between items-center pt-6 border-t">
                    <button type="button" onclick="window.history.back()" 
                            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Previous
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Next
                    </button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>

<script>
    // Word count functionality
    const abstractDiv = document.getElementById('abstract');
    const hiddenAbstract = document.getElementById('hiddenAbstract');
    const wordCount = document.getElementById('wordCount');

    abstractDiv.addEventListener('input', function() {
        const text = this.innerText;
        hiddenAbstract.value = text;
        const words = text.trim().split(/\s+/).filter(word => word.length > 0).length;
        wordCount.textContent = `Word Count: ${words}/500`;
        
        if (words > 500) {
            wordCount.classList.add('text-red-500');
        } else {
            wordCount.classList.remove('text-red-500');
        }
    });

    // Keywords management
    const keywordsContainer = document.getElementById('keywords-container');
const addKeywordBtn = document.getElementById('add-keyword');
const maxKeywordMessage = document.getElementById('max-keyword-message');
let keywordCount = 3;

addKeywordBtn.addEventListener('click', function () {
    if (keywordCount < 5) {
        const keywordWrapper = document.createElement('div');
        keywordWrapper.className = 'relative';

        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'keywords[]';
        input.placeholder = `Keyword ${keywordCount + 1}`;
        input.className = 'w-full px-4 py-2 border border-gray-800 rounded-md focus:ring-green-500 focus:border-green-500';

        const deleteIcon = document.createElement('button');
        deleteIcon.type = 'button';
        deleteIcon.innerHTML = '&#10005;'; // "X" icon
        deleteIcon.className = 'absolute top-2 right-2 text-red-500 hover:text-red-700 focus:outline-none';
        deleteIcon.addEventListener('click', function () {
            keywordWrapper.remove();
            keywordCount--;
            if (keywordCount < 5) {
                addKeywordBtn.disabled = false;
                addKeywordBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                maxKeywordMessage.classList.add('hidden');
            }
        });

        keywordWrapper.appendChild(input);
        keywordWrapper.appendChild(deleteIcon);
        keywordsContainer.appendChild(keywordWrapper);
        keywordCount++;

        if (keywordCount >= 5) {
            addKeywordBtn.disabled = true;
            addKeywordBtn.classList.add('opacity-50', 'cursor-not-allowed');
            maxKeywordMessage.classList.remove('hidden');
        }
    }
});

    // File upload functionality
    function handleFileUpload(event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById('file-name').textContent = file.name;
            document.getElementById('file-preview').classList.remove('hidden');
        }
    }

    function deleteFile() {
        document.getElementById('file-upload').value = '';
        document.getElementById('file-preview').classList.add('hidden');
    }
</script>
@endsection