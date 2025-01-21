

<?php $__env->startSection('content'); ?>
<div id="proposals-container" class="max-w-7xl mx-auto py-4 px-2 sm:px-4 lg:px-6">
<div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-4 sm:space-y-0">
    <!-- Search Section -->
    <div class="flex flex-col sm:flex-row items-center sm:max-w-xs sm:w-auto space-y-4 sm:space-y-0 sm:space-x-4">
        <div class="relative w-full sm:max-w-xs">
            <input id="search-input" type="text" placeholder="Search by Serial number, Submitted by or Title"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 pr-10">
            <!-- Search Icon -->
            <svg id="search-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0 0l6 6"></path>
            </svg>
        </div>
    </div>

    <!-- Reviewer Selection and Assign Button -->
    <div class="flex items-center space-x-6 mt-4 sm:mt-0">
        <div class="relative w-[300px]">
            <!-- Search Input for Reviewers -->
            <input type="text" 
                   id="reviewer-search" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                   placeholder="Search reviewers...">
            
            <!-- Reviewer Dropdown -->
            <div id="reviewer-dropdown-container" 
                 class="hidden absolute left-0 right-0 z-50 mt-1 bg-white border border-gray-300 rounded-lg shadow-xl max-h-60 overflow-y-auto">
                <div class="sticky top-0 p-3 border-b border-gray-200 bg-white">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" id="select-all-reviewers" 
                               class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-gray-700">Select All Reviewers</span>
                    </label>
                </div>
                <div id="reviewer-options" class="relative"></div>
            </div>
        </div>

        <!-- Assign Button -->
        <button onclick="assignAbstractReviewers()" 
                id="assign-button"
                class="px-6 py-3 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            Assign Reviewer
        </button>
    </div>
</div>

    <!-- Bulk Selection -->
    <div class="flex items-center space-x-3 mt-4 sm:mt-0">
        <input type="checkbox" id="select-all-abstracts" 
               class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500"
               onclick="toggleSelectAllAbstracts(this)">
        <label for="select-all-abstracts" class="text-sm text-gray-700">Select All Abstracts</label>
    </div>

    <!-- Loading Spinner -->
    <div id="loading-spinner" class="hidden text-center py-4">
        <svg class="animate-spin h-8 w-8 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <p class="text-blue-600 mt-2">Loading...</p>
    </div>

    <!-- Proposals Table -->
    <div id="proposals-table" class="overflow-x-auto"></div>

    <!-- Pagination -->
    <div id="pagination" class="py-4 flex justify-between"></div>
</div>
<script>
    // Function to show notifications with enhanced styling and animations
    function showNotification(type, message) {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.notification-toast');
        existingNotifications.forEach(notification => {
            notification.remove();
        });

        // Create notification container
        const notification = document.createElement('div');
        notification.className = `notification-toast fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out opacity-0 z-50 flex items-center space-x-2 min-w-[300px]`;
        
        // Define notification types and their styles
        const notificationTypes = {
            error: {
                background: 'bg-red-500',
                icon: `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>`
            },
            warning: {
                background: 'bg-yellow-500',
                icon: `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>`
            },
            success: {
                background: 'bg-green-500',
                icon: `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>`
            },
            info: {
                background: 'bg-blue-500',
                icon: `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>`
            }
        };

        // Get notification style based on type
        const notificationStyle = notificationTypes[type] || notificationTypes.info;
        notification.classList.add(notificationStyle.background);

        // Create notification content
        const iconContainer = document.createElement('div');
        iconContainer.className = 'flex-shrink-0';
        iconContainer.innerHTML = notificationStyle.icon;

        const messageContainer = document.createElement('div');
        messageContainer.className = 'flex-grow text-white text-sm font-medium';
        messageContainer.textContent = message;

        const closeButton = document.createElement('button');
        closeButton.className = 'flex-shrink-0 ml-4 text-white hover:text-gray-200 focus:outline-none';
        closeButton.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>`;
        
        // Add content to notification
        notification.appendChild(iconContainer);
        notification.appendChild(messageContainer);
        notification.appendChild(closeButton);
        
        // Add notification to DOM
        document.body.appendChild(notification);

        // Show notification with animation
        requestAnimationFrame(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        });

        // Close button functionality
        closeButton.addEventListener('click', () => {
            hideNotification(notification);
        });

        // Auto-hide after delay
        const timeout = setTimeout(() => {
            hideNotification(notification);
        }, 5000);

        // Store timeout in notification element
        notification.dataset.timeout = timeout;
    }

    // Function to hide notification with animation
    function hideNotification(notification) {
        // Clear the timeout to prevent duplicate animations
        if (notification.dataset.timeout) {
            clearTimeout(notification.dataset.timeout);
        }

        // Add exit animation
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-10px)';

        // Remove notification after animation
        setTimeout(() => {
            if (notification && notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }
</script>
<script>
// DOM Elements
const searchInput = document.getElementById('reviewer-search');
const dropdownContainer = document.getElementById('reviewer-dropdown-container');
const selectAllReviewers = document.getElementById('select-all-reviewers');
const reviewerOptions = document.getElementById('reviewer-options');
const assignButton = document.getElementById('assign-button');

// Store original reviewer options for filtering
const originalOptions = reviewerOptions.innerHTML;

// Show dropdown when search input is focused
searchInput.addEventListener('focus', () => {
    dropdownContainer.classList.remove('hidden');
    positionDropdown();
});

// Position dropdown relative to viewport
function positionDropdown() {
    const inputRect = searchInput.getBoundingClientRect();
    const dropdownHeight = dropdownContainer.offsetHeight;
    const viewportHeight = window.innerHeight;
    
    // Check if there's room below the input
    const spaceBelow = viewportHeight - inputRect.bottom;
    
    if (spaceBelow < dropdownHeight && inputRect.top > dropdownHeight) {
        // Position above if there's more space there
        dropdownContainer.style.bottom = '100%';
        dropdownContainer.style.top = 'auto';
        dropdownContainer.style.marginTop = '0';
        dropdownContainer.style.marginBottom = '4px';
    } else {
        // Position below
        dropdownContainer.style.top = '100%';
        dropdownContainer.style.bottom = 'auto';
        dropdownContainer.style.marginTop = '4px';
        dropdownContainer.style.marginBottom = '0';
    }
}

// Handle search functionality
searchInput.addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    
    if (searchTerm === '') {
        reviewerOptions.innerHTML = originalOptions;
        return;
    }
    
    const allOptions = Array.from(reviewerOptions.querySelectorAll('label'));
    
    allOptions.forEach(option => {
        const reviewerName = option.querySelector('span').textContent.toLowerCase();
        const shouldShow = reviewerName.includes(searchTerm);
        option.style.display = shouldShow ? 'flex' : 'none';
    });
});

// Handle "Select All Reviewers" checkbox
selectAllReviewers.addEventListener('change', (e) => {
    const visibleCheckboxes = Array.from(reviewerOptions.querySelectorAll('input[type="checkbox"]:not([style*="display: none"])'));
    visibleCheckboxes.forEach(checkbox => {
        checkbox.checked = e.target.checked;
    });
    updateSelectionSummary();
});

// Handle individual reviewer checkboxes
reviewerOptions.addEventListener('change', (e) => {
    if (e.target.type === 'checkbox') {
        updateSelectionSummary();
    }
});

// Update selection summary in search input
function updateSelectionSummary() {
    const selectedCount = document.querySelectorAll('.reviewer-checkbox:checked').length;
    
    if (selectedCount > 0) {
        searchInput.value = `${selectedCount} reviewer${selectedCount > 1 ? 's' : ''} selected`;
        assignButton.disabled = false;
    } else {
        searchInput.value = '';
        assignButton.disabled = true;
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) {
        dropdownContainer.classList.add('hidden');
    }
});

// Update dropdown position on scroll and resize
window.addEventListener('scroll', positionDropdown, true);
window.addEventListener('resize', positionDropdown);

// Function to toggle the "Select All" checkbox for abstracts
function toggleSelectAllAbstracts(source) {
    const checkboxes = document.querySelectorAll('.abstract-submission-checkbox');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = source.checked;
    });
}

// Function to assign reviewers to selected abstracts
function assignAbstractReviewers() {
    // Collect selected abstract IDs
    const selectedAbstracts = Array.from(document.querySelectorAll('.abstract-submission-checkbox:checked'))
        .map((checkbox) => checkbox.value);

    // Collect selected reviewer IDs
    const selectedReviewers = Array.from(document.querySelectorAll('.reviewer-checkbox:checked'))
        .map((checkbox) => checkbox.value);

    // Validate selections
    if (selectedAbstracts.length === 0) {
        alert('Please select at least one abstract.');
        return;
    }

    if (selectedReviewers.length === 0) {
        alert('Please select at least one reviewer.');
        return;
    }

    // Send data to the server via a POST request
    fetch('<?php echo e(route('assign.mass.reviewer')); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            submissions: selectedAbstracts,
            reviewers: selectedReviewers,
        }),
    })
    .then(async response => {
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            // Handle non-JSON response
            const text = await response.text();
            throw new Error('Received non-JSON response from server');
        }
        
        if (!response.ok) {
            return response.json().then(data => Promise.reject(data));
        }
        return response.json();
    })
    .then(data => {
        showNotification('success', data.message || 'Reviewer(s) assigned successfully.');
        setTimeout(() => {
            location.reload();
        }, 1000);
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.errors) {
            // Handle validation errors
            const errorMessages = Object.values(error.errors).flat();
            showNotification('error', errorMessages.join('\n'));
        } else {
            // Handle other errors
            showNotification('error', 'An error occurred. Please try again.');
        }
    });
}
</script>
<script>
 document.addEventListener('DOMContentLoaded', function() {
    fetchReviewers();
});

let reviewersData = [];  // Store fetched reviewers

// Function to fetch reviewers from the backend
function fetchReviewers() {
    fetch('/admin/api/reviewers', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Reviewers:', data); // Log the reviewers data
        reviewersData = data; // Store reviewers data in reviewersData variable
        populateReviewerDropdown(data); // Pass the data to the dropdown population function
    })
    .catch(error => {
        console.error('Error fetching reviewers:', error);
    });
}

// Function to populate the dropdown with reviewers
function populateReviewerDropdown(reviewers) {
    const reviewerOptionsContainer = document.getElementById('reviewer-options');
    reviewerOptionsContainer.innerHTML = ''; // Clear existing options

    if (reviewers.length === 0) {
        reviewerOptionsContainer.innerHTML = '<p class="p-3 text-gray-700">No reviewers found</p>';
    }

    reviewers.forEach(reviewer => {
        const reviewerLabel = document.createElement('label');
        reviewerLabel.classList.add('flex', 'items-center', 'space-x-2', 'p-3', 'hover:bg-gray-50', 'cursor-pointer');
        
        const reviewerCheckbox = document.createElement('input');
        reviewerCheckbox.type = 'checkbox';
        reviewerCheckbox.name = 'reviewers[]';
        reviewerCheckbox.value = reviewer.reg_no;
        reviewerCheckbox.classList.add('reviewer-checkbox', 'w-5', 'h-5', 'text-indigo-600', 'border-gray-300', 'rounded');
        
        const reviewerName = document.createElement('span');
        reviewerName.classList.add('text-sm', 'text-gray-700');
        reviewerName.textContent = `${reviewer.first_name} ${reviewer.last_name}`;

        reviewerLabel.appendChild(reviewerCheckbox);
        reviewerLabel.appendChild(reviewerName);
        reviewerOptionsContainer.appendChild(reviewerLabel);
    });
}
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const proposalsTable = document.getElementById('proposals-table');
    const paginationDiv = document.getElementById('pagination');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-icon');
    const loadingSpinner = document.getElementById('loading-spinner');

    let currentPage = 1;

    // Function to show/hide loading spinner
    function setLoading(loading) {
        if (loading) {
            loadingSpinner.classList.remove('hidden');
            proposalsTable.innerHTML = ''; // Clear table while loading
            paginationDiv.innerHTML = ''; // Clear pagination while loading
        } else {
            loadingSpinner.classList.add('hidden');
        }
    }
    

    // Function to fetch data from the backend
    async function fetchAbstracts(page = 1, search = '') {
        try {
            setLoading(true); // Show loading spinner
            const token = localStorage.getItem('auth_token');
            const response = await fetch(`/admin/api/abstract-submissions?page=${page}&search=${search}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`, // Attach the token in the Authorization header
                },
            });
            const data = await response.json();
            console.log('Received data:', data);
            renderProposals(data);
        } catch (error) {
            console.error('Error fetching proposals:', error);
            proposalsTable.innerHTML = '<p class="text-red-500 text-center py-4">Failed to load data. Please try again later.</p>';
        } finally {
            setLoading(false); // Hide loading spinner
        }
    }
    // Define handleRowClick first
    window.handleRowClick = function(event, serial_number) {
        event.preventDefault();
        console.log(`Navigating to details of: ${serial_number}`);
        window.location.href = `/admin/abstract/details/${serial_number}`;
    };
    // Function to render proposals
    function renderProposals(data) {
    const rows = data.data.map(submission => {
        const pdfPath = submission.pdf_document_path || null;
        
        const viewButtonHtml = pdfPath ? `
            <a href="/storage/${pdfPath}" target="_blank" class="inline-block px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                View
            </a>
        ` : '';
        
        const reviewersList = submission.reviewers.map(reviewer => {
            return `<li class="text-sm text-gray-700">${reviewer.first_name} ${reviewer.last_name}</li>`;
        }).join('');
        const avgScore = submission.average_score ? parseFloat(submission.average_score).toFixed(1) : '<span class="text-gray-500">Not reviewed</span>';
        return `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap" onclick="event.stopPropagation()">
                    <input type="checkbox" class="abstract-submission-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded" value="${submission.serial_number}">
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-900">${submission.title}</div>
                    <div class="text-sm text-gray-500">${submission.serial_number}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">${submission.user_reg_no}</td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    ${new Date(submission.created_at).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    })}
                </td>
                <td class="px-6 py-4 text-sm">
                    ${avgScore}
                </td>
                <td class="px-6 py-4 text-sm">
                    <ul class="list-disc pl-6">
                        ${reviewersList ? reviewersList : '<li class="text-red-500">Not assigned</li>'}
                    </ul>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                        submission.final_status === 'accepted' 
                            ? 'bg-green-200 text-green-800' 
                            : submission.final_status === 'rejected' 
                            ? 'bg-red-200 text-red-800' 
                            : submission.final_status === 'under_review' 
                            ? 'bg-blue-100 text-blue-800' 
                            : submission.final_status === 'revision_required' 
                            ? 'bg-orange-100 text-orange-800' 
                            : 'bg-yellow-100 text-yellow-800'
                    }">
                        ${submission.final_status
                            .replace(/_/g, ' ') // Replace underscores with spaces
                            .replace(/\b\w/g, char => char.toUpperCase())} <!-- Capitalize first letter of each word -->
                    </span>
                </td>
                <td class="px-6 py-4 text-center" onclick="event.stopPropagation()">
                    <a href="javascript:void(0)" onclick="handleRowClick(event, '${submission.serial_number}')"
                    class="text-blue-600 hover:text-blue-800">
                        Details
                    </a>
                    ${viewButtonHtml}
                </td>
            </tr>
        `;
    }).join('');
    

    // Rest of your table HTML remains the same
    proposalsTable.innerHTML = `
        <table class="min-w-full bg-white divide-y divide-gray-200 shadow">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <input type="checkbox" class="abstract-submission-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg. Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewer</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Documents</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                ${rows}
            </tbody>
        </table>
    `;

    // Pagination code remains the same
    paginationDiv.innerHTML = `
        <button ${data.prev_page_url ? '' : 'disabled'} class="px-4 py-2 bg-gray-200 rounded-lg" onclick="fetchAbstracts(${data.current_page - 1})">Previous</button>
        <button ${data.next_page_url ? '' : 'disabled'} class="px-4 py-2 bg-gray-200 rounded-lg" onclick="fetchAbstracts(${data.current_page + 1})">Next</button>
    `;

    currentPage = data.current_page;
}

    // Initial load
    fetchAbstracts();

    // Search functionality
    searchButton.addEventListener('click', () => {
        fetchAbstracts(1, searchInput.value);
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\MSS\mss-project\resources\views/admin/partials/abstracts.blade.php ENDPATH**/ ?>