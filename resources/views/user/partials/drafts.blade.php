@extends('user.layouts.user')

@section('user-content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Draft Submissions</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all your draft submissions that you can continue working on.</p>
            </div>
        </div>
        
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($drafts as $draft)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $draft->title ?? 'Untitled Draft' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($draft->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($draft->updated_at)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Draft
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('user.resume-draft', ['serialNumber' => $draft->serial_number]) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                Continue submission
                                            </a>
                                            <button onclick="deleteDraft('{{ $draft->serial_number }}')" 
                                                    class="text-red-600 hover:text-red-900">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No drafts available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Create notification container if it doesn't exist
function createNotificationContainer() {
    let container = document.getElementById('notification-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'notification-container';
        container.className = 'fixed top-4 right-4 z-50 flex flex-col gap-2';
        document.body.appendChild(container);
    }
    return container;
}

// Show notification function
function showNotification({ message, type = 'success', duration = 3000 }) {
    const container = createNotificationContainer();
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `
        transform translate-x-full opacity-0 
        flex items-center p-4 rounded-lg shadow-lg 
        transition-all duration-300 ease-in-out
        ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}
    `;
    
    // Create icon based on type
    const icon = document.createElement('div');
    icon.className = 'mr-3';
    icon.innerHTML = type === 'success' 
        ? `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
           </svg>`
        : `<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
           </svg>`;
    
    // Create message element
    const text = document.createElement('span');
    text.className = 'text-white font-medium';
    text.textContent = message;
    
    // Create close button
    const closeButton = document.createElement('button');
    closeButton.className = 'ml-4 text-white hover:text-gray-200 focus:outline-none';
    closeButton.innerHTML = `
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    `;
    closeButton.onclick = () => removeNotification(notification);
    
    // Assemble notification
    notification.appendChild(icon);
    notification.appendChild(text);
    notification.appendChild(closeButton);
    container.appendChild(notification);
    
    // Animate in
    requestAnimationFrame(() => {
        notification.classList.remove('translate-x-full', 'opacity-0');
    });
    
    // Auto remove after duration
    setTimeout(() => removeNotification(notification), duration);
    
    return notification;
}

// Remove notification function
function removeNotification(notification) {
    notification.classList.add('translate-x-full', 'opacity-0');
    setTimeout(() => notification.remove(), 300);
}

// Modified delete draft function
async function deleteDraft(serialNumber) {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            throw new Error('CSRF token not found');
        }

        const response = await fetch(`{{ url('/user/drafts/delete') }}/${serialNumber}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
        });

        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Failed to delete the draft');
        }

        showNotification({
            message: 'Draft deleted successfully',
            type: 'success',
            duration: 3000
        });

        // Reload after a short delay to allow the notification to be seen
        setTimeout(() => location.reload(), 1000);
    } catch (error) {
        console.error('Error:', error);
        showNotification({
            message: error.message || 'Error deleting the draft',
            type: 'error',
            duration: 4000
        });
    }
}
</script>
@endsection