<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg">
                <!-- Sidebar and Main Content Section -->
                <div class="flex">
                    <!-- Sidebar -->
                    <div class="w-1/4 bg-gray-800 text-white p-4">
                        <div class="space-y-4">
                            <h3 class="text-xl font-semibold">Admin Menu</h3>
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-white">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')" class="text-white">
                                Users
                            </x-nav-link>
                            <x-nav-link :href="route('admin.submissions')" :active="request()->routeIs('admin.submissions')" class="text-white">
                                Submissions
                            </x-nav-link>
                            <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')" class="text-white">
                                Reports
                            </x-nav-link>
                            <x-nav-link :href="route('admin.documents')" :active="request()->routeIs('admin.documents')" class="text-white">
                                Documents
                            </x-nav-link>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="w-3/4 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-2xl font-bold">{{ __('Dashboard') }}</h2>
                            </div>
                            <div class="flex gap-2">
                                <!-- Profile and Settings Links -->
                                <a href="{{ route('admin.profile') }}" class="btn btn-outline text-sm">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 12c2.212 0 4-1.788 4-4s-1.788-4-4-4-4 1.788-4 4 1.788 4 4 4z" />
                                        <path d="M12 12v1.184c-3.418.413-6 2.757-6 5.816V21h12v-1.826c0-3.058-2.582-5.402-6-5.816V12z" />
                                    </svg>
                                    Profile
                                </a>
                                <a href="{{ route('admin.settings') }}" class="btn btn-outline text-sm">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M12 15.364l-4.242-4.242 4.242-4.242 4.242 4.242-4.242 4.242z" />
                                        <path d="M12 3v18M3 12h18" />
                                    </svg>
                                    Settings
                                </a>
                            </div>
                        </div>

                        <!-- Content Based on Tabs -->
                        <div class="space-y-6">
                            @yield('admin-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
