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

            <!-- Step 2: Active -->
            <div class="flex flex-col items-center">
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-semibold mb-2">
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
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
            <h2 class="text-2xl font-bold text-white">Author Information</h2>
            <p class="text-green-100 text-sm mt-2">Please provide details for all authors. The primary author will be listed as the main contact.</p>
        </div>

        <form id="authorForm" method="POST" action="" class="p-8" novalidate>
            @csrf

            <!-- Authors Container -->
            <div id="authorsContainer" class="space-y-8">
                <!-- Primary Author Section -->
                <div class="author-section bg-gray-50 p-6 border border-gray-800 transition-all duration-300 hover:shadow-md" data-author-index="0">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                        <div class="flex items-center space-x-2">
                        <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-semibold">
                            <h3 class="text-gray-800">1</h3>
                        </div>
                        <span class="text-gray-800">Author</span>
                    </div>
                        
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center space-x-2 text-sm text-gray-600 hover:text-gray-800 cursor-pointer">
                                <input type="checkbox" name="authors[0][is_correspondent]" value="1" 
                                    class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                <span>Corresponding Author</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-5">
                            <!-- First Name -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="authors[0][first_name]" 
                                    class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg"
                                    placeholder="Enter first name"
                                    required>
                                <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
                            </div>

                            <!-- Last Name -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="authors[0][last_name]" 
                                    class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg"
                                    placeholder="Enter last name"
                                    required>
                                <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
                            </div>

                            <!-- Title/Position -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Title/Position <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="authors[0][position]" 
                                    class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg"
                                    placeholder="e.g., Professor, Research Associate"
                                    required>
                                <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-5">
                            <!-- Email -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="authors[0][email]" 
                                    class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg"
                                    placeholder="email@institution.edu"
                                    required>
                                <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
                            </div>

                            <!-- Institution -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Institution/Organization <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="authors[0][institution]" 
                                    class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg"
                                    placeholder="Enter institution name"
                                    required>
                                <div class="error-message text-red-500 text-xs mt-1 hidden"></div>
                            </div>

                            <!-- Department -->
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Department
                                </label>
                                <input type="text" name="authors[0][department]" 
                                    class="form-input block w-full rounded-md border border-gray-800 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition px-4 py-3 text-lg"
                                    placeholder="Enter department name">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Author Button -->
            <div class="mt-6 flex justify-center">
                <button type="button" id="addAuthorBtn" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium 
                    text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Author
                </button>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                <button type="button" onclick="window.history.back()" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium 
                    text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Previous
                </button>

                <a href="{{route('user.step2')}}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium 
                    text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Next
                    <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Help Text -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-500">
            Need assistance? Contact our support team at 
            <a href="mailto:support@example.com" class="text-green-600 hover:text-green-700">support@example.com</a>
        </p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const authorsContainer = document.getElementById('authorsContainer');
    const addAuthorBtn = document.getElementById('addAuthorBtn');
    const MAX_AUTHORS = 5;

    // Function to create new author section
    function createAuthorSection(index) {
        const template = document.querySelector('.author-section').cloneNode(true);

        // Update all input names and clear values
        
        template.querySelectorAll('input').forEach(input => {
            const newName = input.name.replace(/\[\d+\]/, `[${index}]`);
            input.name = newName;
            input.value = '';
            input.checked = false;
        });

        const numberBadge = template.querySelector('.bg-green-500');
        numberBadge.innerText = index + 1;

        // Add remove button if not present
        if (!template.querySelector('.remove-author-btn')) {
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-author-btn text-red-500 hover:text-red-700 focus:outline-none';
            removeBtn.innerHTML = `<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>`;
            
            removeBtn.addEventListener('click', function() {
                template.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    template.remove();
                    updateAuthorNumbers();
                    checkAuthorsLimit();
                }, 200);
            });

            const titleContainer = template.querySelector('.flex.items-center.justify-between');
            titleContainer.appendChild(removeBtn);
        }

        return template;
    }

    // Function to update author numbers
    function updateAuthorNumbers() {
        const sections = document.querySelectorAll('.author-section');
        sections.forEach((section, index) => {
            // Update the number badge
            const numberBadge = section.querySelector('.bg-green-500');
            numberBadge.innerText = index + 1;

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
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateForm()) {
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Saving...
            `;
            
            // Submit the form
            saveFormData(this);
        }
    });

    // Function to validate form
    function validateForm() {
        let isValid = true;
        const requiredFields = form.querySelectorAll('input[required]');
        
        requiredFields.forEach(field => {
            const errorDiv = field.nextElementSibling;
            
            // Clear previous errors
            field.classList.remove('border-red-500');
            errorDiv.classList.add('hidden');
            
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-500');
                errorDiv.textContent = 'This field is required';
                errorDiv.classList.remove('hidden');
            } else if (field.type === 'email' && !validateEmail(field.value)) {
                isValid = false;
                field.classList.add('border-red-500');
                errorDiv.textContent = 'Please enter a valid email address';
                errorDiv.classList.remove('hidden');
            }
        });

        // Check for at least one corresponding author
        const hasCorrespondingAuthor = Array.from(form.querySelectorAll('input[name$="[is_correspondent]"]'))
            .some(checkbox => checkbox.checked);
        
        if (!hasCorrespondingAuthor) {
            isValid = false;
            showNotification('Please designate at least one corresponding author', 'error');
        }

        return isValid;
    }

    // Email validation helper
    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    // Function to show notifications
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out translate-y-full`;
        
        switch (type) {
            case 'error':
                notification.classList.add('bg-red-500', 'text-white');
                break;
            case 'warning':
                notification.classList.add('bg-yellow-500', 'text-white');
                break;
            case 'success':
                notification.classList.add('bg-green-500', 'text-white');
                break;
            default:
                notification.classList.add('bg-blue-500', 'text-white');
        }
        
        notification.textContent = message;
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-y-full');
        }, 100);
        
        // Animate out and remove
        setTimeout(() => {
            notification.classList.add('translate-y-full');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Function to save form data
    async function saveFormData(form) {
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();
            
            if (response.ok) {
                showNotification('Authors information saved successfully!', 'success');
                setTimeout(() => {
                    window.location.href = data.redirect || '/next-step';
                }, 1000);
            } else {
                throw new Error(data.message || 'Something went wrong');
            }
        } catch (error) {
            showNotification(error.message, 'error');
            // Reset submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                Next
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            `;
        }
    }

    // Initialize form state
    checkAuthorsLimit();
});
</script>

<style>
.author-section {
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