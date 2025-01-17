@extends('admin.layouts.admin')

@section('admin-content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">User Management</h1>
        <button onclick="openModal('create-user-modal')" 
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            Add New User
        </button>
    </div>
    {{-- Search Form --}}
    <form action="{{ route('admin.users') }}" method="GET" class="mb-6">
        <div class="flex gap-4">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search by ID, name or email" 
                   class="flex-1 border border-gray-300 rounded-lg shadow-sm p-2">
            <button type="submit" 
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Search
            </button>
        </div>
    </form>
    {{-- Users Table --}}
    <div class="bg-white shadow overflow-hidden h-96">
        @if (session('success'))
            <div class="bg-green-100 border border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif
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
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $user->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $user->email }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ $user->roles->first()->name ?? 'No Role' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
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
                                            <form action="{{ route('users.toggle-status', $user) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="block w-full text-left px-4 py-2 text-sm 
                                                            {{ $user->active ? 'text-red-600 hover:bg-red-100' : 'text-green-600 hover:bg-green-100' }} 
                                                            hover:text-gray-900">
                                                    {{ $user->active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
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
                    <div id="open-role-modal-{{ $user->reg_no }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Assign Role to User</h3>
                            <form 
                                action="{{ route('admin.users.updateRole', ['reg_no' => $user->reg_no]) }}"
                                method="POST">
                                @csrf                            
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Role</label>
                                    <select name="role_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-6 flex justify-end gap-3">
                                    <button type="button" onclick="closeModal('open-role-modal-{{ $user->reg_no }}')" 
                                            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                        Assign Role
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Create User Modal -->
    <div id="create-user-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-lg">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Create User</h3>
            <form action="{{ route('admin.users.create') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Reg_No</label>
                        <input type="text" name="reg_no" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" 
                               placeholder="Enter reg_no" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" 
                               placeholder="Enter user name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" 
                               placeholder="Enter user email" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" 
                               placeholder="Enter default password" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('create-user-modal')" 
                            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Create
                    </button>
                </div>
            </form>
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
</script>
@endsection
    