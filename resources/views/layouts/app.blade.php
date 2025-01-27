<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false, isLoading: true }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TUM Manuscript Submission System</title>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.min.js"></script>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/nprogress@0.2.0/nprogress.css" rel="stylesheet">

   
    <link rel="icon" type="image/png" href="{{ asset('logo/logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo/logo-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo/logo-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo/logo-180x180.png') }}">

   
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    
    <style>
        :root {
            --primary-color:rgb(216, 152, 55);
            --primary-dark: #004F8F;
            --secondary-color: #FFB81C;
            --accent-color:rgb(216, 152, 55);
        }

        /* Enhanced Loading Bar Styles */
        #nprogress .bar {
            background: var(--secondary-color) !important;
            height: 3px !important;
        }
        #nprogress .peg {
            box-shadow: 0 0 10px var(--secondary-color), 0 0 5px var(--secondary-color) !important;
        }
        #nprogress .spinner-icon {
            border-top-color: var(--secondary-color) !important;
            border-left-color: var(--secondary-color) !important;
        }

        /* Alpine.js Cloak */
        [x-cloak] { display: none !important; }

        /* Enhanced Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
            border: 2px solid #f8fafc;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Enhanced Navigation Styles */
        .sidebar-nav-item { 
            @apply flex items-center px-4 py-3 text-gray-600 hover:bg-blue-50 hover:text-blue-900 rounded-lg transition-all duration-200 ease-in-out;
            position: relative;
            overflow: hidden;
        }
        .sidebar-nav-item::after {
            content: '';
            position: absolute;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-color);
            transform: scaleY(0);
            transition: transform 0.2s;
        }
        .sidebar-nav-item:hover::after {
            transform: scaleY(1);
        }
        .sidebar-nav-item.active { 
            @apply bg-blue-50 text-blue-900 font-medium;
            box-shadow: 0 2px 4px rgba(0, 97, 175, 0.1);
        }
        .sidebar-nav-item.active::after {
            transform: scaleY(1);
        }
        .nav-icon { 
            @apply w-5 h-5 mr-3 transition-transform duration-200;
        }
        .sidebar-nav-item:hover .nav-icon {
            @apply transform scale-110;
            color: var(--primary-color);
        }

        /* Enhanced Card Styles */
        .manuscript-card { 
            @apply bg-white rounded-lg p-4 transition-all duration-200 border border-gray-100;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }
        .manuscript-card:hover {
            box-shadow: 0 4px 12px rgba(0, 97, 175, 0.08);
            transform: translateY(-2px);
        }
        .status-badge { 
            @apply px-3 py-1 rounded-full text-xs font-semibold tracking-wide;
            position: relative;
            overflow: hidden;
        }
        .status-badge::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent 0%, rgba(255,255,255,0.2) 50%, transparent 100%);
            transform: translateX(-100%);
            animation: shimmer 2s infinite;
        }
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }
        .status-under-review { 
            @apply bg-yellow-100 text-yellow-800;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }
        .status-accepted { 
            @apply bg-green-100 text-green-800;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }
        .status-rejected { 
            @apply bg-red-100 text-red-800;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .status-draft { 
            @apply bg-gray-100 text-gray-800;
            border: 1px solid rgba(156, 163, 175, 0.3);
        }

        /* Enhanced Header */
        .header-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
        }

        /* Enhanced Dropdown Menus */
        .dropdown-menu {
            @apply bg-white rounded-lg shadow-lg py-1;
            border: 1px solid rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(10px);
        }
        .dropdown-item {
            @apply block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150;
        }

        /* Enhanced Animations */
        .fade-enter {
            opacity: 0;
            transform: translateY(10px);
        }
        .fade-enter-active {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 300ms cubic-bezier(0.4, 0, 0.2, 1),
                        transform 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        .fade-exit {
            opacity: 1;
        }
        .fade-exit-active {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 300ms cubic-bezier(0.4, 0, 0.2, 1),
                        transform 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Profile Button Enhancement */
        .profile-button {
            @apply flex items-center space-x-3 focus:outline-none p-2 rounded-lg transition-all duration-200;
            background: rgba(255, 255, 255, 0.1);
        }
        .profile-button:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .profile-photo {
            @apply h-8 w-8 rounded-full object-cover;
            border: 2px solid rgba(0, 0, 0, 0.8);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Toast Notifications Enhancement */
        .toast-container {
            @apply fixed top-4 right-4 z-50;
        }
        .toast {
            @apply bg-white rounded-lg shadow-lg p-4 mb-4;
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body class="bg-gray-50 antialiased" x-init="
    NProgress.configure({ showSpinner: false });
    NProgress.start();
    window.addEventListener('load', () => {
        NProgress.done();
        isLoading = false;
    });
    window.addEventListener('beforeunload', () => {
        NProgress.start();
    });
">
    <!-- Enhanced Header -->
    <header class="header-gradient shadow-md fixed w-full top-0 z-50">
        <div class="w-full px-4">
            <div class="flex justify-between h-16">
                <!-- Left Section -->
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="p-2 rounded-md text-gray-800 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all duration-200"
                            aria-label="Toggle Sidebar">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="ml-4 text-2xl font-bold text-gray-800 flex items-center">
                        {{ $pageTitle }}
                    </h2>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <!-- Quick Submit Button -->
                    @if($currentRole == 'user')
                    <a href="{{route('user.submit')}}" 
                    class="hidden md:flex items-center px-4 py-2 text-gray-800 rounded-md border border-gray-800 hover:bg-gray-100 hover:text-gray-800 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Submit
                    </a>
                    @endif

                    <!-- Notifications with Badge -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="p-2 text-gray-800 hover:text-gray-500 hover:bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span id="notification-badge" class="absolute top-0 right-0 text-xs font-semibold text-white bg-red-600 rounded-full px-1 py-0.5 hidden"></span>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-80 bg-white shadow-lg py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                    <button onclick="markAllAsRead()" 
                                            class="text-xs text-blue-600 hover:text-blue-800">
                                        Mark all as read
                                    </button>
                                </div>
                            </div>
                            <div id="notifications-dropdown" class="max-h-64 overflow-y-auto">
                                <!-- Notifications will be dynamically added here -->
                            </div>
                        </div>
                    </div>
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 text-white rounded-md hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white/30 group">
                            <img class="h-8 w-8 rounded-full border border-gray-800" 
                                src="{{ asset('storage/' . $user->profile_photo_url ?? 'default-profile.png') }}" 
                                alt="{{ $user->first_name }}">
                            <div class="hidden md:block text-left">
                                <div class="text-sm font-semibold text-gray-800 group-hover:text-gray-800">{{ $user->salutation .  ' ' . $user->first_name }}</div>
                                @if($currentRole == 'admin')
                                    <div class="text-xs text-gray-800 group-hover:text-gray-800">Admin</div>
                                @elseif($currentRole == 'reviewer')
                                    <div class="text-xs text-gray-800 group-hover:text-gray-800">Reviewer</div>
                                @elseif($currentRole == 'user')
                                    <div class="text-xs text-gray-800 group-hover:text-gray-800">User</div>
                                @endif
                            </div>
                        </button>

                        <!-- Profile Dropdown Content -->
                         <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white shadow-lg py-1 z-50 transform origin-top-right transition-all duration-200"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95">

                            <!-- Profile Options Header -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <h3 class="text-sm font-semibold text-gray-900">Your Account</h3>
                            </div>

                            <!-- Profile Dropdown Items -->
                                @if($currentRole == 'admin')
                                    <a href="{{ route('admin.profile') }}" class="dropdown-item px-4 py-2 flex items-center hover:bg-gray-50 transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Edit Profile
                                    </a>
                                @elseif($currentRole == 'user')
                                    <a href="{{ route('user.profile') }}"class="dropdown-item px-4 py-2 flex items-center hover:bg-gray-50 transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Edit Profile
                                    </a>
                                @elseif($currentRole == 'reviewer')
                                    <a href="{{ route('reviewer.profile') }}"class="dropdown-item px-4 py-2 flex items-center hover:bg-gray-50 transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Edit Profile
                                    </a>
                                @endif
                            
                            <div class="border-t border-gray-100"></div>

                            <!-- Sign Out -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full dropdown-item text-red-600 hover:bg-red-50 group px-4 py-2 flex items-center">
                                    <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Enhanced Main Content Area -->
    <div class="flex h-screen pt-16">
        <!-- Enhanced Sidebar -->
        <aside x-cloak
            :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
            class="fixed inset-y-0 left-0 z-40 w-64 shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0" style="background-color: rgb(0, 128, 55);">
            <nav class="mt-16 lg:mt-4 p-4 space-y-4">

                <!-- Author Section for Admins -->
                @if($currentRole == 'admin')
                <div class="space-y-2">
                    <!--<div class="px-4 py-2 text-xs font-semibold text-gray-600 uppercase tracking-wider bg-gray-100 rounded-md shadow-sm">
                        Home
                    </div>-->
                    <!-- Enhanced Navigation Items with Icons -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.abstracts') }}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Conference Papers
                    </a>
                    <a href="{{ route('admin.proposals') }}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Proposal Papers
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Completed
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Manage Users
                    </a>
                    
                    <a href="{{ route('submission-types.index')}}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Submission Types
                    </a>
                    @if(auth()->user()->roles->count() > 1)
                        <div class="role-switcher mt-4 border-t pt-4">
                            <div x-data="{ 
                                open: false, 
                                switchRole(roleName) {
                                    fetch('{{ route('switch.role') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ role: roleName })
                                    })
                                        .then(response => response.json()) 
                                        .then(data => {
                                            if (data.success) {
                                                // Redirect to the route specified in the response
                                                window.location.href = data.redirect;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Role switch failed:', error);
                                        });
                                }
                            }" class="relative">
                                <button 
                                    @click="open = !open"
                                    class="w-full flex items-center justify-between px-3 py-2 font-medium text-gray-100 group hover:text-gray-400 hover:bg-green-800 rounded-md transition-colors"
                                >
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                        Switch Roles
                                    </span>
                                    <svg class="w-4 h-4 transition-transform" 
                                        :class="{'rotate-180': open}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div 
                                    x-show="open"
                                    @click.outside="open = false"
                                    class="absolute z-10 w-full mt-1 shadow-lg rounded-md" style="background-color: rgb(0, 121, 52);"
                                >
                                    <div class="p-2">
                                        @foreach(auth()->user()->roles as $role)
                                        <button
                                            @click="switchRole('{{ $role->name }}')"
                                            class="flex items-center w-full text-left px-3 py-2 text-gray-100 font-medium group hover:text-gray-400 hover:bg-green-800 rounded-md transition-colors duration-200"
                                        >
                                            <span
                                                class="{{ session('current_role') == $role->name ? 'text-gray-700' : 'text-gray-100 group-hover:text-gray-400' }}"
                                            >
                                                {{ ucfirst($role->name) }} Role
                                            </span>
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <p></p>
                    @endif
                </div>
                @elseif($currentRole == 'reviewer')
                <div class="space-y-2">
                    <!--<div class="px-4 py-2 text-xs font-semibold text-gray-600 uppercase tracking-wider bg-gray-100 rounded-md shadow-sm">
                        Home
                    </div>-->
                    <!-- Enhanced Navigation Items with Icons -->
                    <a href="{{ route('reviewer.dashboard') }}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('reviewer.documents') }}" class="flex items-center text-gray-100 hover:text-gray-400 group font-medium hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        To Review
                    </a>
                    <a href="{{ route('reviewer.reviewed')}}" class="flex items-center text-gray-100 hover:text-gray-400 group font-medium hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Reviewed
                    </a>
                    <a href="{{ route('reviewer.profile') }}" class="flex items-center text-gray-100 hover:text-gray-400 group font-medium hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </a>
                    @if(auth()->user()->roles->count() > 1)
                        <div class="role-switcher mt-4 border-t pt-4">
                            <div x-data="{ 
                                open: false, 
                                switchRole(roleName) {
                                    fetch('{{ route('switch.role') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ role: roleName })
                                    })
                                        .then(response => response.json()) 
                                        .then(data => {
                                            if (data.success) {
                                                // Redirect to the route specified in the response
                                                window.location.href = data.redirect;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Role switch failed:', error);
                                        });
                                }
                            }" class="relative">
                                <button 
                                    @click="open = !open"
                                    class="w-full flex items-center justify-between px-3 py-2 font-medium text-gray-100 group hover:text-gray-400 hover:bg-green-800 rounded-md transition-colors"
                                >
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                        Switch Roles
                                    </span>
                                    <svg class="w-4 h-4 transition-transform" 
                                        :class="{'rotate-180': open}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div 
                                    x-show="open"
                                    @click.outside="open = false"
                                    class="absolute z-10 w-full mt-1 shadow-lg rounded-md" style="background-color: rgb(0, 121, 52);"
                                >
                                    <div class="p-2">
                                        @foreach(auth()->user()->roles as $role)
                                        <button
                                            @click="switchRole('{{ $role->name }}')"
                                            class="flex items-center w-full text-left px-3 py-2 text-gray-100 font-medium group hover:text-gray-400 hover:bg-green-800 rounded-md transition-colors duration-200"
                                        >
                                            <span
                                                class="{{ session('current_role') == $role->name ? 'text-gray-700' : 'text-gray-100 group-hover:text-gray-400' }}"
                                            >
                                                {{ ucfirst($role->name) }} Role
                                            </span>
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <p></p>
                    @endif
                </div>
                @elseif($currentRole == 'user')
                <div class="space-y-2">
                    <!--<div class="px-4 py-2 text-xs font-semibold text-gray-600 uppercase tracking-wider bg-gray-100 rounded-md shadow-sm">
                        Home
                    </div>-->
                    <!-- Enhanced Navigation Items with Icons -->
                    <a href="{{route('user.dashboard')}}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{route('user.submit')}}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Submit
                    </a>
                    <a href="{{route('user.documents')}}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Submissions
                    </a>
                    <a href="{{ route('user.drafts') }}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Drafts
                    </a>
                    
                    <a href="{{ route('user.profile') }}" class="flex items-center text-gray-100 font-medium hover:text-gray-400 group hover:bg-green-800 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </a>
                    @if(auth()->user()->roles->count() > 1)
                        <div class="role-switcher mt-4 border-t pt-4">
                            <div x-data="{ 
                                open: false, 
                                switchRole(roleName) {
                                    fetch('{{ route('switch.role') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ role: roleName })
                                    })
                                        .then(response => response.json()) 
                                        .then(data => {
                                            if (data.success) {
                                                // Redirect to the route specified in the response
                                                window.location.href = data.redirect;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Role switch failed:', error);
                                        });
                                }
                            }" class="relative">
                                <button 
                                    @click="open = !open"
                                    class="w-full flex items-center justify-between px-3 py-2 font-medium text-gray-100 group hover:text-gray-400 hover:bg-green-800 rounded-md transition-colors"
                                >
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-500 group-hover:text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                        Switch Roles
                                    </span>
                                    <svg class="w-4 h-4 transition-transform" 
                                        :class="{'rotate-180': open}"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div 
                                    x-show="open"
                                    @click.outside="open = false"
                                    class="absolute z-10 w-full mt-1 shadow-lg rounded-md" style="background-color: rgb(0, 121, 52);"
                                >
                                    <div class="p-2">
                                        @foreach(auth()->user()->roles as $role)
                                        <button
                                            @click="switchRole('{{ $role->name }}')"
                                            class="flex items-center w-full text-left px-3 py-2 text-gray-100 font-medium group hover:text-gray-400 hover:bg-green-800 rounded-md transition-colors duration-200"
                                        >
                                            <span
                                                class="{{ session('current_role') == $role->name ? 'text-gray-700' : 'text-gray-100 group-hover:text-gray-400' }}"
                                            >
                                                {{ ucfirst($role->name) }} Role
                                            </span>
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                            <p></p>
                    @endif
                    
                </div>
                @endif

                <!-- Help Section 
                <div class="space-y-2">
                    <div class="px-4 py-2 mt-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Support
                    </div>
                    <a href="#" class="flex items-center text-gray-700 hover:bg-gray-200 hover:text-gray-900 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c4 0 4 3 4 3s0 4-4 4c-4 0-4-3-4-3s0-4 4-4z" />
                        </svg>
                        FAQ
                    </a>
                    <a href="#" class="flex items-center text-gray-700 hover:bg-gray-200 hover:text-gray-900 rounded-md px-3 py-2 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12h-6M9 12H3m6 6h12M9 18H3" />
                        </svg>
                        Contact Support
                    </a>
                </div>-->
            </nav>
        </aside>

        <!-- Enhanced Main Content -->
        <main class="flex-1 overflow-x-hidden bg-gray-50">
            <div class="container mx-auto px-4 py-6">
                <!-- Enhanced Alert Messages -->
                @if (session('success'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg shadow-sm" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-sm" role="alert">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity lg:hidden">
    </div>

    <!-- Enhanced Scripts -->
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationDropdown = document.getElementById('notifications-dropdown');
    const notificationBadge = document.getElementById('notification-badge');

    function fetchNotifications() {
        return fetch('/notifications', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            updateNotificationUI(data.notifications, data.unread_count);
        })
        .catch(error => {
            notificationDropdown.innerHTML = `
                <div class="p-4 text-center text-red-500">
                    Failed to load notifications
                </div>
            `;
        });
    }

    function updateNotificationUI(notifications, unreadCount) {
        notificationBadge.style.display = unreadCount > 0 ? 'block' : 'none';
        notificationBadge.textContent = unreadCount;
        notificationDropdown.innerHTML = '';
        
        if (notifications.length === 0) {
            notificationDropdown.innerHTML = `
                <div class="p-4 text-center text-gray-500">
                    No notifications
                </div>
            `;
            return;
        }

        notifications.forEach(notification => {
            const notificationElement = document.createElement('div');
            notificationElement.className = `p-4 ${notification.read_at ? 'bg-white' : 'bg-blue-50'} hover:bg-gray-50 border-b border-gray-100`;
            
            notificationElement.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">${escapeHtml(notification.message)}</p>
                        <p class="text-xs text-gray-500 mt-1">${escapeHtml(notification.created_at)}</p>
                        <a href="${escapeHtml(notification.link)}" 
                            class="text-sm text-blue-600 hover:text-blue-800 underline mt-2 block">
                            View Details
                        </a>
                    </div>
                    ${!notification.read_at ? `
                        <button onclick="markAsRead('${notification.id}')" 
                                class="text-xs text-blue-600 hover:text-blue-800">
                            Mark as read
                        </button>
                    ` : ''}
                </div>
            `;
            
            notificationDropdown.appendChild(notificationElement);
        });
    }

    function markAsRead(id) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return fetchNotifications();
        })
        .catch(error => console.error('Error marking notification as read:', error));
    }

    
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Make markAsRead available globally
    window.markAsRead = markAsRead;

    // Initial fetch
    fetchNotifications();
    
    // Fetch notifications every 30 seconds
    setInterval(fetchNotifications, 30000);
});
</script>
<script>
function markAllAsRead() {
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => {
        if (response.ok) {
            // Immediately update UI
            const notificationBadge = document.getElementById('notification-badge');
            notificationBadge.style.display = 'none';
            notificationBadge.textContent = '0';

            // Update background colors of all notifications to white
            const notifications = document.querySelectorAll('#notifications-dropdown > div');
            notifications.forEach(notification => {
                notification.classList.remove('bg-blue-50');
                notification.classList.add('bg-white');
            });

            // Remove all "Mark as read" buttons
            document.querySelectorAll('#notifications-dropdown button').forEach(button => {
                button.remove();
            });

            // Then fetch fresh data
            fetchNotifications();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
    <script>
        // Enhanced Page transitions
        document.addEventListener('DOMContentLoaded', () => {
            const links = document.querySelectorAll('a:not([target="_blank"])');
            links.forEach(link => {
                link.addEventListener('click', (e) => {
                    if (!e.ctrlKey && !e.shiftKey && !e.metaKey && !e.defaultPrevented) {
                        NProgress.start();
                    }
                });
            });

            // Smooth scroll implementation
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // Form submission handling
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                    NProgress.start();
                    // Disable submit button to prevent double submission
                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.classList.add('opacity-75', 'cursor-not-allowed');
                    }
                });
            });
        });
    </script>
</body>
</html>