@extends('user.layouts.user')

@section('user-content')
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
            @foreach(['Abstract', 'Preview', 'Confirm'] as $key => $step)
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-semibold mb-2">
                        {{ $key + 2 }}
                    </div>
                    <span class="text-sm font-medium text-gray-500">{{ $step }}</span>
                </div>
            @endforeach
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

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <ul class="list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form id="authorForm" method="POST" action="{{ route('submit.step1') }}" class="p-8" novalidate>
            @csrf
            <input type="hidden" name="submission_type" value="{{ $submissionType }}">
            
            <!-- Authors Container -->
            <div id="authorsContainer" class="space-y-8">
                @foreach(old('authors', session('all_authors', [['is_correspondent' => false]])) as $index => $author)
                    <div class="author-section bg-gray-50 p-6 border border-gray-800 transition-all duration-300 hover:shadow-md" data-author-index="{{ $index }}">
                        <!-- Author Header -->
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                            <div class="flex items-center space-x-2">
                                <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-semibold">
                                    {{ $index + 1 }}
                                </div>
                                <span class="text-gray-800">Author</span>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800 cursor-pointer">
                                    <input type="hidden" name="authors[0][is_correspondent]" value="0">
                                    <input type="checkbox" 
                                           name="authors[{{ $index }}][is_correspondent]" 
                                           value="1" 
                                           class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                           {{ isset($author['is_correspondent']) && $author['is_correspondent'] ? 'checked' : '' }}>
                                    <span>Corresponding Author</span>
                                </label>
                                @if($index > 0)
                                    <button type="button" class="remove-author-btn text-red-500 hover:text-red-700 focus:outline-none">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Author Fields -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-5">
                                @foreach(['first_name' => 'First Name', 'middle_name' => 'Middle Name', 'surname' => 'Surname'] as $field => $label)
                                    <div class="form-group">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            {{ $label }} <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" 
                                               name="authors[{{ $index }}][{{ $field }}]" 
                                               value="{{ old("authors.$index.$field", $author[$field] ?? '') }}"
                                               class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg @error("authors.$index.$field") border-red-500 @enderror"
                                               placeholder="Enter {{ strtolower($label) }}"
                                               required>
                                        @error("authors.$index.$field")
                                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-5">
                                @foreach(['email' => 'Email Address', 'university' => 'Institution/Organization', 'department' => 'Department'] as $field => $label)
                                    <div class="form-group">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            {{ $label }} <span class="text-red-500">*</span>
                                        </label>
                                        <input type="{{ $field === 'email' ? 'email' : 'text' }}" 
                                               name="authors[{{ $index }}][{{ $field }}]" 
                                               value="{{ old("authors.$index.$field", $author[$field] ?? '') }}"
                                               class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg @error("authors.$index.$field") border-red-500 @enderror"
                                               placeholder="Enter {{ strtolower($label) }}"
                                               required>
                                        @error("authors.$index.$field")
                                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
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
                <a href="{{ route('user.submit') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const authorsContainer = document.getElementById('authorsContainer');
    const addAuthorBtn = document.getElementById('addAuthorBtn');
    const MAX_AUTHORS = 5;
    let authorTemplate = null;

    // Get the template from the first author section
    if (document.querySelector('.author-section')) {
        authorTemplate = document.querySelector('.author-section').cloneNode(true);
    }

    // Function to create new author section
    function createAuthorSection(index) {
        const newSection = authorTemplate.cloneNode(true);
        
        // Update all input names and clear values
        newSection.querySelectorAll('input').forEach(input => {
            const newName = input.name.replace(/\[\d+\]/, `[${index}]`);
            input.name = newName;
            input.value = input.type === 'checkbox' ? '1' : '';
            input.checked = false;
            
            // Clear any error states
            input.classList.remove('border-red-500');
            const errorDiv = input.nextElementSibling;
            if (errorDiv && errorDiv.classList.contains('text-red-500')) {
                errorDiv.textContent = '';
                errorDiv.classList.add('hidden');
            }
        });

        // Update number badge
        const numberBadge = newSection.querySelector('.bg-green-500');
        numberBadge.innerText = index + 1;

        // Add remove button
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-author-btn text-red-500 hover:text-red-700 focus:outline-none';
        removeBtn.innerHTML = `<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>`;

        removeBtn.addEventListener('click', function() {
            newSection.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                newSection.remove();
                updateAuthorNumbers();
                checkAuthorsLimit();
            }, 200);
        });

        const headerDiv = newSection.querySelector('.flex.items-center.justify-between');
        headerDiv.appendChild(removeBtn);

        return newSection;
    }

    // Function to update author numbers
    function updateAuthorNumbers() {
        const sections = document.querySelectorAll('.author-section');
        
        sections.forEach((section, index) => {
            // Update the number badge
            const numberBadge = section.querySelector('.bg-green-500');
            numberBadge.innerText = index + 1;

            // Update input names and check corresponding author status
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

    // Add new author section
    addAuthorBtn.addEventListener('click', function() {
        const currentCount = document.querySelectorAll('.author-section').length;
        if (currentCount < MAX_AUTHORS) {
            const newSection = createAuthorSection(currentCount);
            newSection.classList.add('scale-95', 'opacity-0');
            authorsContainer.appendChild(newSection);
            
            // Animate entrance
            requestAnimationFrame(() => {
                newSection.classList.remove('scale-95', 'opacity-0');
            });
            
            checkAuthorsLimit();
        }
    });

    // Form validation
    const form = document.getElementById('authorForm');
    
    function validateForm() {
        let isValid = true;
        const requiredFields = form.querySelectorAll('input[required]');
        
        // Clear all previous errors
        document.querySelectorAll('.error-message').forEach(error => {
            error.textContent = '';
            error.classList.add('hidden');
        });
        document.querySelectorAll('.form-input').forEach(input => {
            input.classList.remove('border-red-500');
        });

        // Validate each required field
        requiredFields.forEach(field => {
            const errorDiv = field.nextElementSibling;
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

        return isValid;
    }

    // Helper function to show field errors
    function showFieldError(field, message) {
        let errorDiv = field.nextElementSibling;
        if (!errorDiv || !errorDiv.classList.contains('text-red-500')) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'text-red-500 text-xs mt-1';
        field.parentNode.insertBefore(errorDiv, field.nextSibling);
        }
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
    }

    // Email validation helper
    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // Function to show notifications
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out translate-y-full z-50`;
        
        const colors = {
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            success: 'bg-green-500',
            info: 'bg-blue-500'
        };
        
        notification.classList.add(colors[type], 'text-white');
        notification.textContent = message;
        document.body.appendChild(notification);

        // Animate in
        requestAnimationFrame(() => {
            notification.classList.remove('translate-y-full');
        });

        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-y-full');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Form submit handler
    form.addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault();
            showNotification('Please correct the errors before proceeding', 'error');
        }
    });

    // Initialize form state
    checkAuthorsLimit();

    // Add remove button functionality to existing remove buttons
    document.querySelectorAll('.remove-author-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const section = btn.closest('.author-section');
            section.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                section.remove();
                updateAuthorNumbers();
                checkAuthorsLimit();
            }, 200);
        });
    });
});
function validateAuthorData(author) {
    const requiredFields = ['first_name', 'surname', 'email', 'university', 'department'];
    return requiredFields.every(field => author[field] && typeof author[field] === 'string' && author[field].trim() !== '');
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
    event.preventDefault();
    try {
        const saveButton = event.target;
        const originalText = saveButton.innerHTML;
        
        // Update button state
        saveButton.innerHTML = '<span class="spinner-border spinner-border-sm mr-2"></span>Saving...';
        saveButton.disabled = true;

        // Get form data
        const form = document.querySelector('#authorForm');
        if (!form) throw new Error('Form not found');
        
        const formData = new FormData(form);
        const authors = [];
        let currentAuthor = {};
        let currentIndex = -1;

        // Process form data
        for (const [key, value] of formData.entries()) {
            const matches = key.match(/authors\[(\d+)\]\[([^\]]+)\]/);
            if (!matches) continue;

            const [, index, field] = matches;
            const numIndex = parseInt(index);

            if (numIndex !== currentIndex) {
                if (Object.keys(currentAuthor).length > 0 && validateAuthorData(currentAuthor)) {
                    authors.push(currentAuthor);
                }
                currentAuthor = {};
                currentIndex = numIndex;
            }

            currentAuthor[field] = field === 'is_correspondent' ? value === '1' : value.trim();
        }

        // Add last author if valid
        if (Object.keys(currentAuthor).length > 0 && validateAuthorData(currentAuthor)) {
            authors.push(currentAuthor);
        }

        if (authors.length === 0) {
            throw new Error('No valid authors found');
        }

        // Prepare request data
        const requestData = {
            current_step: currentStep,
            authors,
            _token: document.querySelector('meta[name="csrf-token"]')?.content
        };

        // Send request
        const response = await fetch('{{ route("user.saveDraft") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            },
            body: JSON.stringify(requestData)
        });

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
        // Restore button state
        saveButton.innerHTML = originalText;
        saveButton.disabled = false;
    }
}

// Event listener setup
document.addEventListener('DOMContentLoaded', () => {
    const saveDraftBtn = document.querySelector('[data-action="save-draft"]');
    if (saveDraftBtn) {
        saveDraftBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const currentStep = saveDraftBtn.dataset.step;
            saveDraft(currentStep);
        });
    }
});
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
@endsection