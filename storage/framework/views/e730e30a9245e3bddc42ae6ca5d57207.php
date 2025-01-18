<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>TUM-MSS</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/lucide.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm fixed w-full top-0 z-50" style="background-color: #d89837 !important">
        <div class="w-full px-2">
            <div class="flex justify-between h-16">
                <!-- Logo & Title -->
                <div class="flex items-center">
                    <!-- Toggle Button for Sidebar -->
                    <button @click="sidebarOpen = !sidebarOpen" 
                            class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h2 class="ml-4 text-2xl font-bold text-black-600">
                        <?php echo e($pageTitle); ?>

                    </h2>
                </div>

                <!-- Right Header Section -->
                <div class="flex items-center space-x-4">
                    <!-- Search Bar 
                    <div class="hidden md:block">
                        <div class="relative">
                            <input type="text" 
                                   class="w-64 pl-10 pr-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent" 
                                   placeholder="Search...">
                            <div class="absolute left-3 top-2.5">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>-->

                    <!-- Notifications with Badge -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span id="notification-badge" class="absolute top-0 right-0 text-xs font-semibold text-white bg-red-600 rounded-full px-1 py-0.5 hidden"></span>
                        </button>

                        <div x-show="open" @click.away="open = false" 
                            class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-1 z-50">
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

                    <!-- Enhanced Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-3 focus:outline-none hover:bg-gray-100 p-2 rounded-lg transition duration-150">
                            <img class="h-9 w-9 rounded-full object-cover border-2 border-black-400" 
                                 src="<?php echo e(asset('storage/' . $user->profile_photo_url ?? 'default-profile.png')); ?>" 
                                 alt="<?php echo e($user->first_name); ?>">
                            <div class="hidden md:block text-left">
                                <div class="text-sm font-semibold text-gray-800"><?php echo e($user->salutation .  ' ' . $user->first_name); ?></div>
                                <?php if(auth()->user()->hasRole('admin')): ?>
                                    <div class="text-xs text-gray-500">Admin</div>
                                <?php elseif(auth()->user()->hasRole('reviewer')): ?>
                                    <div class="text-xs text-gray-500">Reviewer</div>
                                <?php elseif(auth()->user()->hasRole('user')): ?>
                                    <div class="text-xs text-gray-500">User</div>
                                <?php endif; ?>
                            </div>
                            <svg class="h-5 w-5 text-black-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Enhanced Profile Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 transform origin-top-right transition-all duration-200">
                            <div class="py-1">
                                <?php if(auth()->user()->hasRole('admin')): ?>
                                    <a href="<?php echo e(route('admin.profile')); ?>" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 transition duration-150">
                                        Profile
                                    </a>
                                <?php elseif(auth()->user()->hasRole('user')): ?>
                                    <a href="<?php echo e(route('user.profile')); ?>" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 transition duration-150">
                                        Profile
                                    </a>
                                <?php elseif(auth()->user()->hasRole('reviewer')): ?>
                                    <a href="<?php echo e(route('reviewer.profile')); ?>" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 transition duration-150">
                                        Profile
                                    </a>
                                <?php endif; ?>
                            <!--<a href="#" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 transition duration-150">
                                <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Settings
                            </a>-->
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" 
                                        class="flex w-full items-center px-4 py-2 text-sm text-red-700 hover:bg-red-100 transition duration-150">
                                    <svg class="mr-3 h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex pt-16 h-screen">
        <!-- Enhanced Sidebar -->
        <div class="fixed inset-y-0 left-0 z-30 w-64 transition-all duration-300 transform"style="background-color: #0b8a1a !important;"
             :class="{'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen}">
                <div class="flex items-center">
                    <span class="mx-2 text-2xl font-semibold text-white">Dashboard</span>
                </div>  
            <nav class="mt-10">
            <?php if(auth()->user()->hasRole('user')): ?>
                <a class="hover:bg-green-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                   href="<?php echo e(route('user.dashboard')); ?>">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="mx-3">Dashboard</span>
                </a>
                <a class="hover:bg-green-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                   href="<?php echo e(route('user.submit')); ?>">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4l16 8-16 8V4z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12l8-8" />
                    </svg>
                    <span class="mx-3">Start Submission</span>
                </a>
                <a class="hover:bg-green-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                   href="<?php echo e(route('user.documents')); ?>">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 012-2h4l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                    </svg>
                    <span class="mx-3">My Submissions</span>
                </a>
                <a class="hover:bg-green-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                   href="<?php echo e(route('user.profile')); ?>">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="mx-3">My Profile</span>
                </a>
            <?php elseif(auth()->user()->hasRole('admin')): ?>
                <a class="hover:bg-green-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                   href="<?php echo e(route('admin.dashboard')); ?>">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="mx-3">Dashboard</span>
                </a>

                <a class="hover:bg-green-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                   href="<?php echo e(route('admin.documents')); ?>">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="mx-3">Documents</span>
                </a>

                <a class="hover:bg-green-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                    href="<?php echo e(route('admin.reports')); ?>">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="mx-3">Completed</span>
                </a>

                <a class="hover:bg-green-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                   href="<?php echo e(route('admin.users')); ?>">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="mx-3">Users</span>
                </a>
            <?php elseif(auth()->user()->hasRole('reviewer')): ?>
                <a class="hover:bg-green-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                   href="<?php echo e(route('reviewer.dashboard')); ?>">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="mx-3">Dashboard</span>
                </a>

                <a class="hover:bg-blue-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                    href="<?php echo e(route('reviewer.documents')); ?>">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m2 8H6a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                    </svg>
                        <span class="mx-3">In Review</span>
                </a>

                <a class="hover:bg-green-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                   href="<?php echo e(route('reviewer.reviewed')); ?>">
                   <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="mx-3">Completed</span>
                </a>

                <a class="hover:bg-green-800 flex items-center px-4 py-3 text-white text-lg font-medium rounded-lg transition-colors duration-150"
                   href="<?php echo e(route('reviewer.profile')); ?>">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="mx-3">Profile</span>
                </a>
            <?php endif; ?>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 transition-all duration-300"
            :class="{'ml-64': sidebarOpen, 'ml-1': !sidebarOpen}">
            <div class="w-full px-4 py-4">
                <!-- Recent Activity Section -->
                <div class="bg-white rounded-lg shadow-sm mb-8">
                    <!-- Content Based on Route -->
                    <div class="p-6">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>                    
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div x-show="sidebarOpen" 
         class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"
         @click="sidebarOpen = false">
    </div>
</body>
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
</html><?php /**PATH D:\MSS\mss-project\resources\views/layouts/app.blade.php ENDPATH**/ ?>