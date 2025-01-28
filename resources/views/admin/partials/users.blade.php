@extends('layouts.app')

@section('content')
<div class="container mx-auto">
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Users</h1>
</div>
    {{-- Search Form --}}
    <form action="{{ route('admin.users') }}" method="GET" class="mb-6" id="search-form">
        <div class="flex gap-4">
            <input type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Search by RegNo, first name, last name or email" 
                class="flex-1 border border-gray-300 rounded-lg shadow-sm p-2"
                id="search-input">
            <button type="submit" 
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Search
            </button>
        </div>
    </form>
    {{-- Users Table --}}
    <div class="bg-white shadow overflow-hidden h-96 overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reg_No</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $user->reg_no }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $user->first_name . ' ' . $user->last_name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                        @if($user->roles->count() > 0)
                            {{ $user->roles->pluck('name')->implode(', ') }} 
                            <span class="text-xs text-gray-500 ml-2">({{ $user->roles->count() }} roles)</span>
                        @else
                            <span class="text-gray-500">No Roles</span>
                        @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span id="status-{{ $user->reg_no }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex justify-center gap-2">
                                <div class="relative">
                                    <button 
                                        class="dropdown-button px-3 py-1 text-xs font-medium text-white bg-gray-600 hover:bg-gray-700 rounded-lg flex items-center gap-2"
                                        data-user-id="{{ $user->reg_no }}">
                                        Actions
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10 hidden"
                                        data-user-id="{{ $user->reg_no }}">
                                        <div class="py-2">
                                            <!--<button onclick="openModal('edit-user-modal-{{ $user->reg_no }}')" 
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                                Edit
                                            </button>-->
                                            <button onclick="openModal('open-role-modal-{{ $user->reg_no }}')" 
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                                Assign Role
                                            </button>
                                            <button 
                                                id="toggle-status-{{ $user->reg_no }}"
                                                onclick="toggleStatus('{{ $user->reg_no }}')" 
                                                class="block w-full text-left px-4 py-2 text-sm
                                                    {{ $user->active ? 'text-red-600 hover:bg-red-100' : 'text-green-600 hover:bg-green-100' }} 
                                                    hover:text-gray-900">
                                                {{ $user->active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                            <button onclick="deleteUser('{{ $user->reg_no }}')" 
                                                class="block w-full text-left px-4 py-2 text-sm hover:bg-red-100 text-red-600 hover:text-red-900">
                                                    Delete
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!-- Edit User Modal -->
                    <div id="edit-user-modal-{{ $user->reg_no }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Edit User: {{ $user->name }}</h3>
                            <form action="{{ route('admin.users.update', $user->reg_no) }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" 
                                            value="{{ $user->name }}"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" 
                                            value="{{ $user->email }}"
                                            required>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-end gap-3">
                                    <button type="button" onclick="closeModal('edit-user-modal-{{ $user->reg_no }}')" 
                                            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                  <!-- Assign Role Modal -->
                  <div id="open-role-modal-{{ $user->reg_no }}" 
                    class="fixed inset-0 z-50 hidden bg-black bg-opacity-30 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-lg font-semibold text-gray-800">Assign Roles</h2>
                                <button 
                                    onclick="closeModal('open-role-modal-{{ $user->reg_no }}')" 
                                    class="text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <form 
                                action="{{ route('admin.users.updateRole', ['reg_no' => $user->reg_no]) }}"
                                method="POST">
                                @csrf
                                
                                <div class="space-y-4">
                                    @foreach($roles as $role)
                                        <label class="flex items-center cursor-pointer">
                                            <input 
                                                type="checkbox" 
                                                name="roles[]" 
                                                value="{{ $role->id }}"
                                                class="form-checkbox h-4 w-4 text-indigo-600 rounded border-gray-300 mr-2"
                                                {{ $user->roles->contains('id', $role->id) ? 'checked' : '' }}
                                            >
                                            <span class="text-sm text-gray-700">{{ $role->name }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="mt-6 flex justify-end space-x-2">
                                    <button 
                                        type="button"
                                        onclick="closeModal('open-role-modal-{{ $user->reg_no }}')"
                                        class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-md">
                                        Cancel
                                    </button>
                                    <button 
                                        type="submit" 
                                        class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                        Update Roles
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        
        <!-- Pagination Container -->
        <div class="px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if ($users->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed rounded-md">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $users->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Previous
                                </a>
                            @endif

                            @if ($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    Next
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed rounded-md">
                                    Next
                                </span>
                            @endif
                        </div>

                        <!-- Desktop View -->
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ $users->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $users->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $users->total() }}</span>
                                    results
                                </p>
                            </div>

                            <!-- Page Numbers -->
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($users->onFirstPage())
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @else
                                        <a href="{{ $users->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                        @if ($page == $users->currentPage())
                                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                                                {{ $page }}
                                            </span>
                                        @else
                                            <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                {{ $page }}
                                            </a>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($users->hasMorePages())
                                        <a href="{{ $users->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @else
                                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Handle dropdown toggles
    document.querySelectorAll('.dropdown-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation();
            const userId = this.dataset.userId;
            const dropdownMenu = document.querySelector(`.dropdown-menu[data-user-id="${userId}"]`);
            
            // Close all other dropdowns first
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu.dataset.userId !== userId) {
                    menu.classList.add('hidden');
                }
            });
            
            dropdownMenu.classList.toggle('hidden');
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // Modal functions
    window.openModal = function(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    };

    window.closeModal = function(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    };

    // Handle modal outside clicks
    document.querySelectorAll('[id$="-modal"]').forEach(modal => {
        modal.addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal(this.id);
            }
        });
    });

    // Handle form submissions with CSRF
    document.querySelectorAll('form').forEach(form => {
        if (!form.querySelector('input[name="_token"]')) {
        // Create a hidden input element for the CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;

        // Append the CSRF input to the form
        form.appendChild(csrfInput);
    }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    // Handle Real-time search
    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('input', function () {
        const searchValue = searchInput.value;

        fetch("{{ route('admin.users') }}?search=" + searchValue, {
            method: "GET",
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector('.users-table').innerHTML = data.users;
        });
    });

    // Handle delete user via AJAX
    window.deleteUser = function (userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            fetch("/admin/delete/users/" + userId, {
                method: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                location.reload(); // Reload the page to reflect the changes
            });
        }
    };

    // Toggle the user's status using AJAX
        window.toggleStatus = function (userId) {
        fetch("/admin/users/" + userId + "/toggle-status", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => response.json()) // Parse JSON response
        window.location.reload()
        .then(data => {
            if (data.active !== undefined) {
                const statusElement = document.querySelector(`#status-${userId}`);
                const toggleButton = document.querySelector(`#toggle-status-${userId}`);
                if (data.active) {
                    statusElement.textContent = "Active";
                    toggleButton.textContent = "Deactivate";
                    statusElement.classList.add('bg-green-100', 'text-green-800');
                    statusElement.classList.remove('bg-red-100', 'text-red-800');
                    toggleButton.classList.add('text-red-600', 'hover:bg-red-100');
                    toggleButton.classList.remove('text-green-600', 'hover:bg-green-100');
                } else {
                    statusElement.textContent = "Inactive";
                    toggleButton.textContent = "Activate";
                    statusElement.classList.add('bg-red-100', 'text-red-800');
                    statusElement.classList.remove('bg-green-100', 'text-green-800');
                    toggleButton.classList.add('text-green-600', 'hover:bg-green-100');
                    toggleButton.classList.remove('text-red-600', 'hover:bg-red-100');
                }
                
            } else {
                console.error('Error toggling status:', data);
            }
        })
        .catch(error => console.error('Error toggling status:', error));
    };
});
</script>
@endsection
    