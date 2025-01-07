

<?php $__env->startSection('user-content'); ?>
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

<!-- Main Content -->
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg overflow-hidden">
    <!-- Form Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
            <h2 class="text-2xl font-bold text-white">Abstract Submission</h2>
            <p class="text-green-100 text-sm mt-2">Please fill in the details of your abstract submission</p>
    </div>
    <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    <form 
        class="p-8" 
        id="step2Form" 
        method="POST" 
        action="<?php echo e(route('submit.step2_research')); ?>" 
        enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="submission_type" value="abstract">
        <div id="authorsContainer" class="space-y-8">
                <!-- Primary Author Section -->
                <div class="author-section bg-gray-50 p-6 border border-gray-800 transition-all duration-300 hover:shadow-md" data-author-index="0">
            <!-- Title Input -->
            <div class="form-group">
                <label for="article-title" class="block text-lg font-medium text-gray-700 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" 
                        id="article-title" 
                        name="article_title" 
                        placeholder="Enter the title of your article" 
                        value="<?php echo e(old('article_title', $abstract['article_title'] ?? '')); ?>" 
                        class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg <?php $__errorArgs = ['article_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        required>
                    <?php $__errorArgs = ['article_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500">Best/p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="text-sm text-gray-500 mt-1">Title should be clear and descriptive</div>
                </div>
            </div>

            <!-- Sub-Theme Selection -->
            <div class="form-group">
                <label id="sub-theme-label" for="sub-theme" class="block text-lg font-medium text-gray-700 mb-2">
                    Sub-Theme <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select id="sub-theme" 
                        name="sub_theme" 
                        class="w-full h-12 px-4 border rounded-lg shadow-sm transition-colors appearance-none bg-white 
                            focus:ring-2 focus:ring-green-500 focus:border-green-500
                            <?php $__errorArgs = ['sub_theme'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php else: ?> border-gray-800 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        aria-labelledby="sub-theme-label" 
                        required>
                        <option value="">Select a sub-theme</option>
                        <?php $__currentLoopData = $subThemes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($theme); ?>" <?php echo e(old('sub_theme') == $theme ? 'selected' : ''); ?>>
                                <?php echo e($theme); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700" aria-hidden="true">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                    <?php $__errorArgs = ['sub_theme'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>


            <!-- Abstract Input -->
            <div class="form-group">
                <label for="abstract" class="block text-lg font-medium text-gray-700 mb-2">
                    Abstract <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div id="abstract" 
                        contenteditable="true" 
                        class="w-full min-h-[200px] p-4 border border-gray-800 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors bg-white <?php $__errorArgs = ['abstract'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        data-placeholder="Enter your abstract here..."><?php echo e(old('abstract', $abstract['abstract'] ?? '')); ?></div>
                    <input type="hidden" name="abstract" id="hiddenAbstract" value="<?php echo e(old('abstract', $abstract['abstract'] ?? '')); ?>">
                    <div class="flex justify-between mt-2">
                        <p id="wordCount" class="text-sm text-gray-600">Word Count: 0/500</p>
                        <p class="text-sm text-gray-500">Maximum 500 words</p>
                    </div>
                    <?php $__errorArgs = ['abstract'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <!-- Keywords Input -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keywords (3-5 keywords)</label>
                <div id="keywords-container" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Pre-fill keywords from session or previous input -->
                    <?php $__currentLoopData = $abstract['keywords']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="relative">
                            <input type="text" name="keywords[]" value="<?php echo e(old('keywords.' . $index, $keyword)); ?>" placeholder="Keyword <?php echo e($index + 1); ?>" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <!-- Set the default to 3, if there are less than 3 pre-filled keywords -->
                    <?php for($i = count($abstract['keywords']); $i < 3; $i++): ?>
                        <div class="relative">
                            <input type="text" name="keywords[]" placeholder="Keyword <?php echo e($i + 1); ?>" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                        </div>
                    <?php endfor; ?>
                </div>
                <button type="button" id="add-keyword" 
                        class="mt-4 px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Add Keyword
                </button>
                <p id="max-keyword-message" class="text-sm text-red-500 mt-2 hidden">You have reached the maximum of 5 keywords.</p>
            </div>
            <div class="mb-8">
                <label for="file-upload" class="block text-sm font-medium text-gray-700 mb-1">
                    Upload Research Proposal <span class="text-red-500">(PDF or Word format, max 100MB)</span>
                </label>
                <div class="mt-2">
                    <input type="file" id="file-upload" name="pdf_document" 
                        accept=".pdf,.doc,.docx"
                        onchange="handleFileUpload(event)"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                </div>
                <p class="mt-1 text-sm text-gray-500">Accepted formats: PDF (.pdf), Word (.doc, .docx)</p>

                <!-- File Preview Section -->
                <div id="file-preview" class="<?php echo e(session('abstract.pdf_document_path') ? '' : 'hidden'); ?> mt-4 p-4 bg-gray-50 rounded-md">
                    <p class="text-sm text-gray-600">
                        Selected file: 
                        <span id="file-name" class="font-medium">
                            <?php echo e(basename(session('abstract.pdf_document_path')) ?? 'No file selected'); ?>

                        </span>
                    </p>
                    <button type="button" onclick="deleteFile()" 
                        class="mt-2 px-3 py-1 text-sm text-red-600 hover:text-red-700 focus:outline-none">
                        Remove file
                    </button>
                </div>

            </div>

        

        <!-- Action Buttons -->
        <div class="flex justify-between mt-12">
            <a href="<?php echo e(route('user.step1_research')); ?>" 
                class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Previous
            </a>
            <button type="button" 
                onclick="saveDraft(event, 2)" 
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Save as Draft
            </button>
            <button 
                type="submit" 
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Next
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
        </div>
</div>
    </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editableDiv = document.getElementById('abstract');
    const hiddenInput = document.getElementById('hiddenAbstract');
    const wordCountElem = document.getElementById('wordCount');
    const MAX_WORDS = 500;

    // Set placeholder text
    editableDiv.dataset.placeholder = "Enter your abstract here...";
    if (!editableDiv.textContent.trim()) {
        editableDiv.classList.add('empty');
    }

    editableDiv.addEventListener('focus', function() {
        if (editableDiv.classList.contains('empty')) {
            editableDiv.classList.remove('empty');
            editableDiv.textContent = '';
        }
    });

    editableDiv.addEventListener('blur', function() {
        if (!editableDiv.textContent.trim()) {
            editableDiv.classList.add('empty');
        }
    });

    function updateWordCount() {
        let text = editableDiv.innerText || editableDiv.textContent;
        text = text.replace(/[^a-zA-Z\s.,;:'"\-?!()]/g, '');
        let words = text.trim().split(/\s+/).filter(Boolean);
        let wordCount = words.length;

        wordCountElem.textContent = `Word Count: ${wordCount}/${MAX_WORDS}`;
        wordCountElem.className = wordCount > MAX_WORDS ? 'text-sm text-red-500' : 'text-sm text-gray-600';

        if (wordCount > MAX_WORDS) {
            words = words.slice(0, MAX_WORDS);
            text = words.join(' ');
            editableDiv.innerText = text;
        }

        hiddenInput.value = text;
    }

    editableDiv.addEventListener('input', updateWordCount);
    document.getElementById('step2Form').addEventListener('submit', updateWordCount);
    updateWordCount();

  // Keywords Management
    const keywordsContainer = document.getElementById('keywords-container');
    const addKeywordBtn = document.getElementById('add-keyword');
    const maxKeywordMessage = document.getElementById('max-keyword-message');

    // Initialize keyword count based on existing keywords, or default to 3 if empty
    let keywordCount = keywordsContainer.querySelectorAll('input').length || 3;

    addKeywordBtn.addEventListener('click', function () {
        if (keywordCount < 5) {
            const keywordWrapper = document.createElement('div');
            keywordWrapper.className = 'relative';

            // Create input
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'keywords[]';
            input.placeholder = `Keyword ${keywordCount + 1}`;
            input.className = 'w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500';

            // Create delete button
            const deleteIcon = document.createElement('button');
            deleteIcon.type = 'button';
            deleteIcon.innerHTML = '&#10005;'; // "X" icon
            deleteIcon.className = 'absolute top-2 right-2 text-red-500 hover:text-red-700 focus:outline-none';
            deleteIcon.setAttribute('aria-label', 'Remove keyword'); // Accessibility
            deleteIcon.title = 'Remove keyword'; // Tooltip
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

            // Disable button and show message if limit is reached
            if (keywordCount >= 5) {
                addKeywordBtn.disabled = true;
                addKeywordBtn.classList.add('opacity-50', 'cursor-not-allowed');
                maxKeywordMessage.classList.remove('hidden');
            }
        }
    });
    // Form validation
    const form = document.getElementById('step2Form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        // Validate title
        const titleInput = document.getElementById('article-title');
        if (!titleInput.value.trim()) {
            showError(titleInput, 'Title is required');
            return;
        }

        // Validate sub-theme
        const subThemeSelect = document.getElementById('sub-theme');
        if (!subThemeSelect.value) {
            showError(subThemeSelect, 'Please select a sub-theme');
            return;
        }

        // Validate abstract
        const abstractText = hiddenInput.value.trim();
        if (!abstractText) {
            showError(editableDiv, 'Abstract is required');
            return;
        }

        const wordCount = abstractText.split(/\s+/).filter(Boolean).length;
        if (wordCount > MAX_WORDS) {
            showError(editableDiv, `Abstract must not exceed ${MAX_WORDS} words`);
            return;
        }

        // Validate keywords
        const keywords = Array.from(keywordsContainer.querySelectorAll('input'))
            .map(input => input.value.trim())
            .filter(Boolean);

        if (keywords.length < 3) {
            showError(keywordsContainer, 'At least 3 keywords are required');
            return;
        }

        // Validation for file upload
        const fileInput = document.getElementById('file-upload');
        if (!fileInput.files.length && !document.getElementById('file-preview').querySelector('#file-name').textContent) {
            showError(fileInput, 'Please upload a PDF or Word document');
            return;
        }

        // If all validation passes, submit the form
        this.submit();
    });

    function showError(element, message) {
        // Remove any existing error messages
        const existingError = element.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        // Add error styling
        element.classList.add('border-red-500');

        // Create and append error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message text-red-500 text-sm mt-1';
        errorDiv.textContent = message;
        element.parentElement.appendChild(errorDiv);

        // Scroll to the error
        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Clear error styling on input
    document.querySelectorAll('input, select, #abstract').forEach(element => {
        element.addEventListener('input', function() {
            this.classList.remove('border-red-500');
            const errorMessage = this.parentElement.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        });
    });
});


function goBack() {
        window.history.back();
}
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
    fetch('user/delete-file-session', { 
        method: 'POST', 
        headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 
        'Content-Type': 'application/json', },
        body: JSON.stringify({})
     });
}
function showNotification(message, type = 'success') {
    const alert = document.createElement('div');
    alert.className = `fixed top-4 right-4 px-6 py-3 rounded shadow-lg z-50 transition-all duration-500 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    } text-white`;
    alert.textContent = message;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 3000);
}
async function saveDraft(event, currentStep) {
    let saveButton = null;
    const originalText = 'Save as Draft';

    try {
        // Ensure we have the event
        if (!event || !event.target) {
            throw new Error('Invalid event');
        }

        // Get the button and store it
        saveButton = event.target;
        
        // Update button state
        saveButton.innerHTML = '<span class="spinner-border spinner-border-sm mr-2"></span>Saving...';
        saveButton.disabled = true;

        // Get form data
        const form = document.querySelector('#step2Form');
        if (!form) throw new Error('Form not found');
        
        const formData = new FormData(form);
        formData.append('current_step', currentStep);

        // Add serial number if exists
        const serialNumber = localStorage.getItem('draft_serial_number');
        if (serialNumber) {
            formData.append('serial_number', serialNumber);
        }

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            throw new Error('CSRF token not found');
        }

        // Send request
        const response = await fetch('<?php echo e(route("user.save.proposal.draft")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        });

        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Server returned an invalid response');
        }

        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Error saving draft');
        }

        if (data.serial_number) {
            localStorage.setItem('draft_serial_number', data.serial_number);
        }

        showNotification('Draft saved successfully!', 'success');
        
    } catch (error) {
        showNotification(error.message || 'Error saving draft', 'error');
    } finally {
        // Ensure button exists before resetting it
        if (saveButton) {
            saveButton.disabled = false;
            saveButton.innerHTML = originalText;
        }
    }
}
</script>
<style>
#abstract[data-placeholder]:empty:before {
    content: attr(data-placeholder);
    color: #9CA3AF;
}

#abstract.empty[data-placeholder]:before {
    content: attr(data-placeholder);
    color: #9CA3AF;
}

.form-group {
    position: relative;
}

.error-message {
    position: absolute;
    bottom: -1.5rem;
    left: 0;
    right: 0;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\email-verification-app\resources\views\user\partials\step2_research.blade.php ENDPATH**/ ?>