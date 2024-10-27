<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Homepage</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-cover" style="background-image: url('{{ asset('images/OMSC-bg1.jpg') }}');">
    <div class="bg-white bg-opacity-80 p-4 shadow-md">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ Auth::user()->profile_picture ? Auth::user()->profile_picture : asset('images/default-profile.png') }}" alt="Profile Picture" class="h-12 w-12 mr-2 rounded-full object-cover">
                <span class="font-bold text-lg">{{ Auth::user()->name }}</span>
            </div>
            <nav class="flex space-x-4">
                {{--
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-500">Dashboard</a>
                <a href="{{ route('admin.views.submittedReports') }}" class="text-gray-700 hover:text-blue-500">Submitted Report</a>
                <a href="{{ route('admin.views.myFiles') }}" class="text-gray-700 hover:text-blue-500">My Files</a>
                <a href="{{ route('admin.clearance.manage') }}" class="text-gray-700 hover:text-blue-500">Clearance</a> 
                --}}
                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="text-gray-700 hover:text-blue-500 inline-flex items-center">
                                Account
                                <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('admin.profile.edit')" class="text-gray-700 hover:text-blue-500">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="text-gray-700 hover:text-blue-500">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
                <a href="#" class="text-gray-700 hover:text-blue-500">About Us</a>
            </nav>
        </div>
    </div>
    <div class="min-h-screen flex flex-col items-center justify-start pt-48 relative overflow-hidden">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="absolute top-0 left-1/2 transform -translate-x-1/2 mt-8 z-10">
            <div class="bg-white bg-opacity-80 rounded-full p-0 shadow-lg transition-transform duration-300 hover:scale-105">
                <img src="{{ asset('images/OMSCLogo.png') }}" alt="OMSC Logo" class="h-32 w-32">
            </div>
        </a>
        
        <!-- Welcome Message -->
        <a href="{{ route('admin.dashboard') }}" class="block relative z-10 text-center mb-12">
            <div class="cursor-pointer">
                <h1 class="text-6xl font-bold text-white mb-6 shadow-text transition-all duration-300 hover:scale-105">
                    Welcome to OMSC IQA ClearVault
                </h1>
                <p class="text-2xl text-white shadow-text bg-black bg-opacity-20 inline-block px-6 py-3 rounded-lg transform hover:translate-y-1 transition-transform duration-300">
                    Efficiently manage and secure your quality assurance documents
                </p>
            </div>
        </a>
        <div class="h-24"></div>
    </div>

    <!-- Quick Actions -->
    <div class="flex justify-center items-center max-w-4xl w-full mx-auto relative z-20 -mt-72">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="backdrop-blur-sm bg-white/5 p-6 rounded-lg shadow-lg border border-white/50">
                <h2 class="text-2xl font-semibold text-white mb-4">Quick Actions</h2>
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.dashboard') }}" class="text-white hover:text-blue-200 transition duration-300">Dashboard</a></li>
                    <li><a href="{{ route('admin.views.clearances') }}" class="text-white hover:text-blue-200 transition duration-300">Go to Clearance</a></li>
                    <li><a href="{{ route('admin.views.faculty') }}" class="text-white hover:text-blue-200 transition duration-300">View & Manage Your Faculty</a></li>
                    <li><a href="{{ route('admin.views.college') }}" class="text-white hover:text-blue-200 transition duration-300">Manage Colleges and Programs</a></li>
                </ul>
            </div>
            <div class="backdrop-blur-sm bg-white/5 p-6 rounded-lg shadow-lg border border-white/50">
                <h2 class="text-2xl font-semibold text-white mb-4">About Us</h2>
                <p class="text-white">
                    OMSC IQA ClearVault is Occidental Mindoro State College's secure platform for Institutional Quality Assurance data banking and clearance management. We provide efficient storage and protection for all your important QA documents.
                </p>
            </div>
        </div>
    </div>

    <style>
        .shadow-text {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
    <footer class="bg-white py-6 mt-24">
        <div class="container mx-auto text-center text-gray-800">
            <p class="text-sm">&copy; 2024 OMSCS IQA ClearVault. All rights reserved.</p>
            <div class="flex justify-center space-x-4 mt-4">
                <a href="#" class="hover:text-indigo-400">Privacy Policy</a>
                <a href="#" class="hover:text-indigo-400">Terms of Service</a>
                <a href="#" class="hover:text-indigo-400">Contact Us</a>
            </div>
        </div>
    </footer>
    
</body>

</html>