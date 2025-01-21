

<?php $__env->startSection('content'); ?>
<!-- Progress Tracker -->
<div class="max-w-4xl mx-auto mb-8">
    <div class="relative">
        <!-- Progress Line -->
        <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2"></div>
        <div class="absolute top-1/2 left-0 w-1/4 h-1 bg-green-500 -translate-y-1/2 transition-all duration-500"></div>

        <!-- Steps -->
        <div class="relative flex justify-between">
            <!-- Step 1: Complete -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-semibold mb-2 shadow-lg ring-4 ring-green-100">
                    1
                </div>
                <span class="text-sm font-medium text-green-600">Authors</span>
            </div>

            <!-- Steps 2-4 remain the same -->
            <?php $__currentLoopData = ['Abstract', 'Preview', 'Confirm']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-semibold mb-2">
                        <?php echo e($key + 2); ?>

                    </div>
                    <span class="text-sm font-medium text-gray-500"><?php echo e($step); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
            <h2 class="text-2xl font-bold text-white">Author Information</h2>
            <p class="text-green-100 text-sm mt-2">Please provide details for all authors. The primary author will be listed as the main contact.</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <ul class="list-disc list-inside text-sm text-red-700">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <form id="authorForm" method="POST" action="<?php echo e(route('submit.step1_research')); ?>" class="p-8" novalidate>
            <?php echo csrf_field(); ?>
            <input type="hidden" name="submission_type" value="<?php echo e($submissionType); ?>">
            
            <!-- Authors Container -->
            <div id="authorsContainer" class="space-y-8">
                <?php $__currentLoopData = old('authors', session('all_authors', [['is_correspondent' => false]])); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="author-section bg-gray-50 p-6 border border-gray-800 transition-all duration-300 hover:shadow-md" data-author-index="<?php echo e($index); ?>">
                        <!-- Author Header -->
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                            <div class="flex items-center space-x-2">
                                <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-semibold">
                                    <?php echo e($index + 1); ?>

                                </div>
                                <span class="text-gray-800">Author</span>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800 cursor-pointer">
                                    <input type="hidden" name="authors[0][is_correspondent]" value="0">
                                    <input type="checkbox" 
                                           name="authors[<?php echo e($index); ?>][is_correspondent]" 
                                           value="1" 
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                           <?php echo e(isset($author['is_correspondent']) && $author['is_correspondent'] ? 'checked' : ''); ?>>
                                    <span>Corresponding Author</span>
                                </label>
                                <?php if($index > 0): ?>
                                    <button type="button" class="remove-author-btn text-red-500 hover:text-red-700 focus:outline-none">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Author Fields -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-5">
                                <?php $__currentLoopData = ['first_name' => 'First Name', 'middle_name' => 'Middle Name', 'surname' => 'Surname']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            <?php echo e($label); ?> 
                                            <?php if($field !== 'middle_name'): ?> 
                                                <span class="text-red-500">*</span>
                                            <?php endif; ?>
                                        </label>
                                        <input type="text" 
                                            name="authors[<?php echo e($index); ?>][<?php echo e($field); ?>]" 
                                            value="<?php echo e(old("authors.$index.$field", $author[$field] ?? '')); ?>"
                                            class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg <?php $__errorArgs = ["authors.$index.$field"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            placeholder="Enter <?php echo e(strtolower($label)); ?>"
                                            <?php if($field !== 'middle_name'): ?> required <?php endif; ?>>
                                        <?php $__errorArgs = ["authors.$index.$field"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-red-500 text-xs mt-1"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-5">
                                <?php $__currentLoopData = ['email' => 'Email Address', 'university' => 'Institution/Organization', 'department' => 'Department']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            <?php echo e($label); ?> <span class="text-red-500">*</span>
                                        </label>
                                        <input type="<?php echo e($field === 'email' ? 'email' : 'text'); ?>" 
                                               name="authors[<?php echo e($index); ?>][<?php echo e($field); ?>]" 
                                               value="<?php echo e(old("authors.$index.$field", $author[$field] ?? '')); ?>"
                                               class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg <?php $__errorArgs = ["authors.$index.$field"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               placeholder="Enter <?php echo e(strtolower($label)); ?>"
                                               required>
                                        <?php $__errorArgs = ["authors.$index.$field"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="text-red-500 text-xs mt-1"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Add Author Button -->
            <div class="mt-6 flex justify-center">
                <button type="button" id="addAuthorBtn" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Author
                </button>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('user.submit')); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Previous
                </a>
                <button type="button" 
                    onclick="saveDraft(event, 1)" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Save as Draft
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Next
                    <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Help Text -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-500">
            Need assistance? Contact our support team at 
            <a href="mailto:support@tum.ac.ke" class="text-green-600 hover:text-green-700">support@tum.ac.ke</a>
        </p>
    </div>
</div>

<script defer>
    const authorsContainer = document.getElementById('authorsContainer');
    const addAuthorBtn = document.getElementById('addAuthorBtn');
    const form = document.getElementById('authorForm');
    const MAX_AUTHORS = 5;
    let authorTemplate = null;

    // Initialize template from first author section
    const firstAuthorSection = document.querySelector('.author-section');
    if (firstAuthorSection) {
        authorTemplate = firstAuthorSection.cloneNode(true);
        // Reset template values
        authorTemplate.querySelectorAll('input').forEach(input => {
            if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = input.defaultChecked;
            } else {
                input.value = '';
            }
        });
    }

    // Function to create new author section
    function createAuthorSection(index) {
        const newSection = authorTemplate.cloneNode(true);
        
        // Update all input names and clear values
        newSection.querySelectorAll('input').forEach(input => {
            const newName = input.name.replace(/\[\d+\]/, `[${index}]`);
            input.name = newName;
            if (input.type === 'checkbox') {
                input.checked = false;
            } else {
                input.value = '';
            }
            input.classList.remove('border-red-500');
        });

        // Update number badge
        const numberBadge = newSection.querySelector('.bg-green-500');
        if (numberBadge) {
            numberBadge.textContent = index + 1;
        }

        // Set up remove button
        const headerDiv = newSection.querySelector('.flex.items-center.justify-between');
        if (headerDiv) {
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-author-btn text-red-500 hover:text-red-700 focus:outline-none';
            removeBtn.innerHTML = `
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>`;
            
            removeBtn.addEventListener('click', function() {
                deleteAuthorSection(newSection);
            });
            
            headerDiv.appendChild(removeBtn);
        }

        return newSection;
    }

    // Function to delete author section
    function deleteAuthorSection(section) {
        section.style.opacity = '0';
        section.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            section.remove();
            updateAuthorNumbers();
            checkAuthorsLimit();
        }, 300);
    }

    // Function to update author numbers
    function updateAuthorNumbers() {
        const sections = document.querySelectorAll('.author-section');
        
        sections.forEach((section, index) => {
            // Update number badge
            const numberBadge = section.querySelector('.bg-green-500');
            if (numberBadge) {
                numberBadge.textContent = index + 1;
            }

            // Update input names
            section.querySelectorAll('input').forEach(input => {
                const newName = input.name.replace(/\[\d+\]/, `[${index}]`);
                input.name = newName;
            });
        });
    }

    // Function to check authors limit
    function checkAuthorsLimit() {
        const authorCount = document.querySelectorAll('.author-section').length;
        addAuthorBtn.disabled = authorCount >= MAX_AUTHORS;
        addAuthorBtn.classList.toggle('opacity-50', authorCount >= MAX_AUTHORS);
        
        if (authorCount >= MAX_AUTHORS) {
            showNotification('Maximum number of authors reached (5)', 'warning');
        }
    }

    // Function to show notifications
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out opacity-0 z-50`;
        
        const colors = {
            error: 'bg-red-500',
            warning: 'bg-yellow-800',
            success: 'bg-green-500',
            info: 'bg-blue-500'
        };
        
        notification.classList.add(colors[type], 'text-white');
        notification.textContent = message;
        document.body.appendChild(notification);

        // Animate in
        requestAnimationFrame(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        });

        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(20px)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Email validation
    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // Form validation
    function validateForm() {
        let isValid = true;
        const requiredFields = form.querySelectorAll('input[required]');
        
        // Clear previous errors
        document.querySelectorAll('.error-message').forEach(error => error.remove());
        document.querySelectorAll('.form-input').forEach(input => {
            input.classList.remove('border-red-500');
        });

        // Check required fields
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-500');
                showFieldError(field, 'This field is required');
            } else if (field.type === 'email' && !validateEmail(field.value)) {
                isValid = false;
                field.classList.add('border-red-500');
                showFieldError(field, 'Please enter a valid email address');
            }
        });

        // Check for corresponding author
        const hasCorrespondingAuthor = Array.from(document.querySelectorAll('input[name$="[is_correspondent]"]'))
            .some(checkbox => checkbox.checked);
        
        if (!hasCorrespondingAuthor) {
            isValid = false;
            showNotification('Please select at least one corresponding author', 'error');
        }

        return isValid;
    }

    // Show field error
    function showFieldError(field, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message text-red-500 text-xs mt-1';
        errorDiv.textContent = message;
        field.parentNode.insertBefore(errorDiv, field.nextSibling);
    }

    // Save draft function
    async function saveDraft(event, currentStep) {
        event.preventDefault();
        const saveButton = event.target;
        const originalText = saveButton.innerHTML;

        try {
            // Update button state
            saveButton.innerHTML = 'Saving...';
            saveButton.disabled = true;

            // Collect form data
            const formData = new FormData(form);
            const authors = [];
            let currentAuthor = {};
            let currentIndex = -1;

            for (const [key, value] of formData.entries()) {
                const matches = key.match(/authors\[(\d+)\]\[([^\]]+)\]/);
                if (!matches) continue;

                const [, index, field] = matches;
                const numIndex = parseInt(index);

                if (numIndex !== currentIndex) {
                    if (Object.keys(currentAuthor).length > 0) {
                        authors.push(currentAuthor);
                    }
                    currentAuthor = {};
                    currentIndex = numIndex;
                }

                currentAuthor[field] = field === 'is_correspondent' ? value === '1' : value.trim();
            }

            if (Object.keys(currentAuthor).length > 0) {
                authors.push(currentAuthor);
            }

            const saveDraftRoute = "<?php echo e(route('user.save.proposal.draft')); ?>";
            const response = await fetch(saveDraftRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    current_step: currentStep,
                    authors: authors,
                })
            });

            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Error saving draft');
            }

            showNotification('Draft saved successfully!', 'success');
            
            if (data.serial_number) {
                localStorage.setItem('draft_serial_number', data.serial_number);
            }

        } catch (error) {
            showNotification(error.message || 'Error saving draft', 'error');
        } finally {
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        }
    }

    // Event Listeners
    if (addAuthorBtn) {
        addAuthorBtn.addEventListener('click', function() {
            const currentCount = document.querySelectorAll('.author-section').length;
            if (currentCount < MAX_AUTHORS) {
                const newSection = createAuthorSection(currentCount);
                newSection.style.opacity = '0';
                newSection.style.transform = 'scale(0.95)';
                authorsContainer.appendChild(newSection);
                
                requestAnimationFrame(() => {
                    newSection.style.opacity = '1';
                    newSection.style.transform = 'scale(1)';
                });
                
                checkAuthorsLimit();
            }
        });
    }

    if (form) {
        form.addEventListener('submit', function(event) {
            if (!validateForm()) {
                event.preventDefault();
            }
        });
    }

    // Delegate remove button click event to authorsContainer
    authorsContainer.addEventListener('click', function(event) {
        if (event.target.closest('.remove-author-btn')) {
            const section = event.target.closest('.author-section');
            if (section) {
                deleteAuthorSection(section);
            }
        }
    });

    // Initialize form state
    checkAuthorsLimit();

    // Encapsulate saveDraft function within a namespace
    window.MyApp = window.MyApp || {};
</script>

<style>
.author-section {
    transform-origin: center;
    transition: all 0.3s ease-in-out;
}

.form-input:focus {
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
}

.error-message {
    transform: translateY(-10px);
    transition: all 0.2s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.animate-shake {
    animation: shake 0.5s ease-in-out;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/user/partials/step1_research.blade.php ENDPATH**/ ?>