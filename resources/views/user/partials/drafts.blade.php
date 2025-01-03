@extends('user.layouts.user')

@section('user-content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-8">
        <div class="sm:flex sm:items-center mb-6">
            <div class="sm:flex-auto">
                <h2 class="text-xl font-semibold text-gray-900">{{ ucfirst($type) }} Drafts</h2>
                <p class="mt-2 text-sm text-gray-700">
                    Below is the list of all your {{ $type }} drafts. You can continue working on them or delete the ones you no longer need.
                </p>
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
                                @if($type === 'proposal')
                                    @forelse ($proposalDrafts as $draft)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $draft->title ?? 'Untitled Draft' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($draft->created_at)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($draft->updated_at)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Draft</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('user.resume.proposal.draft', ['serialNumber' => $draft->serial_number]) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 mr-3 transition duration-200 ease-in-out">Continue submission</a>
                                                <button onclick="deleteDraft('{{ $draft->serial_number }}', 'proposals')" 
                                                        class="text-red-600 hover:text-red-900 transition duration-200 ease-in-out">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No proposal drafts available</td>
                                        </tr>
                                    @endforelse
                                @elseif($type === 'abstract')
                                    @forelse ($abstractDrafts as $draft)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $draft->title ?? 'Untitled Draft' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($draft->created_at)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($draft->updated_at)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Draft</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('user.resume-draft', ['serialNumber' => $draft->serial_number]) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 mr-3 transition duration-200 ease-in-out">Continue submission</a>
                                                <button onclick="deleteDraft('{{ $draft->serial_number }}', 'abstracts')" 
                                                        class="text-red-600 hover:text-red-900 transition duration-200 ease-in-out">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No abstract drafts available</td>
                                        </tr>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="notification-container" class="fixed top-4 right-4 z-50 flex flex-col gap-2"></div>

<script>
function showNotification({ message, type = 'success', duration = 3000 }) {
    const container = document.getElementById('notification-container');
    const notification = document.createElement('div');
    notification.className = `transform translate-x-full opacity-0 flex items-center p-4 rounded-lg shadow-lg transition-all duration-300 ease-in-out ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    
    const icon = document.createElement('div');
    icon.className = 'mr-3';
    icon.innerHTML = type === 'success' 
        ? '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>'
        : '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
    
    const text = document.createElement('span');
    text.className = 'text-white font-medium';
    text.textContent = message;
    
    const closeButton = document.createElement('button');
    closeButton.className = 'ml-4 text-white hover:text-gray-200 focus:outline-none';
    closeButton.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
    closeButton.onclick = () => removeNotification(notification);
    
    notification.appendChild(icon);
    notification.appendChild(text);
    notification.appendChild(closeButton);
    container.appendChild(notification);
    
    requestAnimationFrame(() => notification.classList.remove('translate-x-full', 'opacity-0'));
    setTimeout(() => removeNotification(notification), duration);
}

function removeNotification(notification) {
    notification.classList.add('translate-x-full', 'opacity-0');
    setTimeout(() => notification.remove(), 300);
}

async function deleteDraft(serialNumber, draftType) {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) throw new Error('CSRF token not found');

        const url = draftType === 'proposals' 
            ? `{{ url('/user/proposal-drafts/delete') }}/${serialNumber}`
            : `{{ url('/user/drafts/delete') }}/${serialNumber}`;

        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Failed to delete the draft');

        showNotification({
            message: `Draft deleted successfully`,
            type: 'success'
        });

        setTimeout(() => location.reload(), 500);
    } catch (error) {
        console.error('Error:', error);
        showNotification({
            message: error.message || 'Error deleting the draft',
            type: 'error',
            duration: 4000
        });
    }
}

@if(session('success'))
    showNotification({
        message: "{{ session('success') }}",
        type: 'success'
    });
@endif
</script>
@endsection