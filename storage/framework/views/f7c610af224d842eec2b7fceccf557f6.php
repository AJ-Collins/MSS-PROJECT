

<?php $__env->startSection('user-content'); ?>
<div class="px-6 py-4 border-b border-gray-200 shadow-sm bg-white">
    <h2 class="text-2xl font-semibold text-gray-800 tracking-tight">Upload Article</h2>
</div>

<div class="max-w-2xl mx-auto mt-6">
    <div class="bg-white shadow-md rounded-lg p-8">
        <form id="uploadForm" action="<?php echo e(route('user.upload.article')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="serial_number" value="<?php echo e($submission->serial_number); ?>">
            <div class="space-y-6">
                <!-- Document Upload -->
                <div>
                    <label for="document" class="block text-sm font-medium text-gray-800 mb-2">Upload Your Article</label>
                    <div id="fileUploadArea" 
                         class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 transition-colors duration-200"
                         ondragover="handleDragOver(event)"
                         ondragleave="handleDragLeave(event)"
                         ondrop="handleDrop(event)">
                        <input type="file" 
                               name="document" 
                               id="document" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                               accept=".pdf,.doc,.docx" 
                               required 
                               onchange="handleFileChange(event)">
                        <div id="fileUploadPlaceholder" class="flex flex-col items-center justify-center h-full pointer-events-none">
                            <svg class="w-12 h-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-4 text-sm text-gray-600 font-medium">Drag and drop your file here, or click to select</p>
                            <p class="mt-2 text-xs text-gray-500">Supported formats: PDF, DOC, DOCX (Max size: 500MB)</p>
                        </div>
                    </div>

                    <!-- File Preview -->
                    <div id="selectedFile" class="hidden mt-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-8 h-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div>
                                        <p id="fileName" class="text-sm font-medium text-gray-700"></p>
                                        <p id="fileSize" class="text-xs text-gray-500 mt-1"></p>
                                    </div>
                                </div>
                                <button type="button" 
                                        class="text-sm text-red-600 hover:text-red-700 font-medium hover:underline focus:outline-none" 
                                        onclick="removeFile()">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Progress -->
                    <div id="uploadProgress" class="hidden mt-4">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div id="progressBar" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
                        </div>
                        <p id="progressText" class="text-xs text-gray-500 mt-2 text-center">0%</p>
                    </div>

                    <!-- Error Message -->
                    <div id="errorMessage" class="hidden mt-4 text-sm text-red-600"></div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            id="submitButton"
                            class="w-full inline-flex justify-center items-center py-3 px-6 border border-transparent text-lg font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-md transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="submitText">Submit</span>
                        <svg id="submitSpinner" class="hidden animate-spin ml-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const form = document.getElementById('uploadForm');
    const fileInput = document.getElementById('document');
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileUploadPlaceholder = document.getElementById('fileUploadPlaceholder');
    const selectedFileContainer = document.getElementById('selectedFile');
    const fileNameDisplay = document.getElementById('fileName');
    const fileSizeDisplay = document.getElementById('fileSize');
    const progressContainer = document.getElementById('uploadProgress');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const errorMessage = document.getElementById('errorMessage');
    const submitButton = document.getElementById('submitButton');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');

    const MAX_FILE_SIZE = 500 * 1024 * 1024; // 500MB in bytes
    const ALLOWED_TYPES = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.classList.remove('hidden');
        setTimeout(() => {
            errorMessage.classList.add('hidden');
        }, 5000);
    }

    function validateFile(file) {
        if (!file) return false;
        if (!ALLOWED_TYPES.includes(file.type)) {
            showError('Invalid file type. Please upload a PDF, DOC, or DOCX file.');
            return false;
        }
        if (file.size > MAX_FILE_SIZE) {
            showError('File is too large. Maximum size is 500MB.');
            return false;
        }
        return true;
    }

    function handleFileChange(event) {
        const file = event.target.files[0];
        if (!file) return;
        
        if (validateFile(file)) {
            fileNameDisplay.textContent = file.name;
            fileSizeDisplay.textContent = formatFileSize(file.size);
            fileUploadPlaceholder.classList.add('hidden');
            selectedFileContainer.classList.remove('hidden');
            errorMessage.classList.add('hidden');
        } else {
            removeFile();
        }
    }

    function handleDragOver(event) {
        event.preventDefault();
        fileUploadArea.classList.add('bg-gray-100', 'border-indigo-300');
    }

    function handleDragLeave(event) {
        event.preventDefault();
        fileUploadArea.classList.remove('bg-gray-100', 'border-indigo-300');
    }

    function handleDrop(event) {
        event.preventDefault();
        fileUploadArea.classList.remove('bg-gray-100', 'border-indigo-300');
        
        const file = event.dataTransfer.files[0];
        if (file && validateFile(file)) {
            fileInput.files = event.dataTransfer.files;
            handleFileChange({ target: { files: [file] } });
        }
    }

    function removeFile() {
        fileInput.value = '';
        fileNameDisplay.textContent = '';
        fileSizeDisplay.textContent = '';
        fileUploadPlaceholder.classList.remove('hidden');
        selectedFileContainer.classList.add('hidden');
        progressContainer.classList.add('hidden');
        errorMessage.classList.add('hidden');
    }

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        if (!fileInput.files[0]) {
            showError('Please select a file to upload.');
            return;
        }

        // Show loading state
        submitButton.disabled = true;
        submitText.textContent = 'Uploading...';
        submitSpinner.classList.remove('hidden');
        progressContainer.classList.remove('hidden');

        const formData = new FormData(form);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', form.action);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);

        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percentComplete = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percentComplete + '%';
                progressText.textContent = percentComplete + '%';
            }
        });

        xhr.addEventListener('load', function() {
            if (xhr.status === 200) {
                // Success
                submitText.textContent = 'Upload Successful!';
                submitSpinner.classList.add('hidden');
                setTimeout(() => {
                    window.location.href = '/user/dashboard';
                }, 1000);
            } else {
                // Error
                showError('Upload failed. Please try again.');
                submitButton.disabled = false;
                submitText.textContent = 'Upload Document';
                submitSpinner.classList.add('hidden');
                progressContainer.classList.add('hidden');
            }
        });

        xhr.addEventListener('error', function() {
            showError('Upload failed. Please check your connection and try again.');
            submitButton.disabled = false;
            submitText.textContent = 'Upload Document';
            submitSpinner.classList.add('hidden');
            progressContainer.classList.add('hidden');
        });

        xhr.send(formData);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\email-verification-app\resources\views/user/partials/article_upload.blade.php ENDPATH**/ ?>