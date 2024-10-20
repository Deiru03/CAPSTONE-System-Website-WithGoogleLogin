<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Dashboard') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <style>
         .profile-picture {
            width: 40px; /* Adjust size as needed */
            height: 40px;
            border-radius: 50%; /* Make it circular */
            object-fit: cover; /* Ensure the image covers the area */
            margin-right: 10px; /* Space between image and text */
        }
        .profile-section {
            display: flex;
            align-items: center;
            padding: 10px;
        }
    </style>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">
            <!-- Sidebar -->
            <div class="w-60 bg-gray-800 text-white h-screen fixed z-10 overflow-y-auto">
                <div class="profile-section">
                    @if(Auth::check())
                        @if(Auth::user()->profile_picture)
                            <img src="{{ Auth::user()->profile_picture }}" alt="Profile Picture" class="h-6 w-6 rounded-full mr-2">
                        @else
                            <div class="h-6 w-6 rounded-full mr-2 flex items-center justify-center text-white font-bold" style="background-color: {{ '#' . substr(md5(Auth::user()->name), 0, 6) }};">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-lg font-semibold">{{ Auth::user()->name }}</span>
                    @endif
                    {{-- <img src="{{ asset('images/OMSCLogo.png') }}" alt="Logo" class="h-12 w-12 mr-2">
                    <span class="text-lg font-semibold">{{ Auth::user()->name }}</span> --}}
                </div> 
                <div class="mt-auto p-1">
                    {{-- <div class="mt-auto p-5">
                        <div class="flex flex-col items-center mt-0 profile-section">
                            <img src="{{ Auth::user()->profile_picture }}" alt="Profile Picture" class="profile-picture" style="width: 80px; height: 80px;">
                            <p class="text-center mt-2 text-lg font-semibold text-white">
                                {{ Auth::user()->name }}
                            </p>
                        </div>
                    </div> --}}
                </div>
                <nav class="mt-10">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('faculty.dashboard') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M12 3l9 9-9 9-9-9 9-9z" />
                        </svg>
                        <span class="{{ request()->routeIs('dashboard') ? 'text-indigo-300 font-semibold' : '' }}">Dashboard</span>
                    </a>

                    <!-- Clearances -->
                    <div x-data="{ clearancesOpen: {{ request()->routeIs('faculty.views.clearances') || request()->routeIs('faculty.clearances.index') ? 'true' : 'false' }} }">
                        <a @click="clearancesOpen = !clearancesOpen" class="flex items-center px-10 py-4 hover:bg-gray-700 cursor-pointer {{ request()->routeIs('faculty.views.clearances') || request()->routeIs('faculty.clearances.index') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>                          
                            <span class="{{ request()->routeIs('faculty.views.clearances') || request()->routeIs('faculty.clearances.index') ? 'text-indigo-300 font-semibold' : '' }}">Clearances</span>
                            <svg :class="{'rotate-90': clearancesOpen}" class="ml-auto h-5 w-5 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <div x-show="clearancesOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="pl-16">
                            <a href="{{ route('faculty.views.clearances') }}" class="flex items-center px-4 py-2 text-sm hover:bg-gray-700 {{ request()->routeIs('faculty.views.clearances') ? 'bg-gray-700 text-indigo-300' : 'text-gray-300' }}">
                                <span>View Clearances</span>
                            </a>
                            <a href="{{ route('faculty.clearances.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-gray-700 {{ request()->routeIs('faculty.clearances.index') ? 'bg-gray-700 text-indigo-300' : 'text-gray-300' }}">
                                <span>Clearance Checklists</span>
                            </a>
                        </div>
                    </div>

                    <!-- Submitted Reports -->
                    <a href="{{ route('faculty.views.submittedReports') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('faculty.views.submittedReports') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                        </svg>                                                    
                        <span class="{{ request()->routeIs('faculty.views.submittedReports') ? 'text-indigo-300 font-semibold' : '' }}">Submitted Reports</span>
                    </a> 

                    <!-- My Files -->
                    <a href="{{ route('faculty.views.myFiles') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('faculty.views.myFiles') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>                                                  
                        <span class="{{ request()->routeIs('faculty.views.myFiles') ? 'text-indigo-300 font-semibold' : '' }}">My Files</span>
                    </a>

                    <!-- Test Page -->
                    <a href="{{ route('faculty.views.test') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('faculty.views.test') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                        </svg>
                        <span class="{{ request()->routeIs('faculty.views.test') ? 'text-indigo-300 font-semibold' : '' }}">Test Page</span>
                        </a>

                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-10 py-4 hover:bg-gray-700 {{ request()->routeIs('profile.edit') ? 'bg-gray-700 border-l-4 border-indigo-500' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span class="{{ request()->routeIs('profile.edit') ? 'text-indigo-300 font-semibold' : '' }}">Profile</span>
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="flex items-center w-full">
                        @csrf
                        <button type="submit" class="flex items-center w-full text-left px-10 py-4 hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </nav>
                
            <!-- About Us -->
            <a href="" class="flex items-center px-10 py-4 hover:bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 {{-- request()->routeIs('about.us') ? 'bg-gradient-to-r from-indigo-500 to-purple-600 border-l-4 border-indigo-500' : '' --}} transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="{{ request()->routeIs('about.us') ? 'text-white font-semibold' : '' }}">About Us</span>
            </a>
            </div>
            
            <div class="flex-1 ml-60"> <!-- Added margin-left to prevent content from being behind the sidebar -->
                <!-- Page Content -->
                @include('layouts.navigation')
        
                <!-- Page Heading -->
                @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <button onclick="window.history.back()" class="mr-4 text-gray-600 hover:text-gray-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                    </svg>
                                </button>
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                    {{ $header }} <!-- Use the header variable -->
                                </h2>
                            </div>
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        @if(Auth::user()->profile_picture)
                                            <img src="{{ Auth::user()->profile_picture }}" alt="Profile Picture" class="h-6 w-6 rounded-full mr-2">
                                        @else
                                            <div class="h-6 w-6 rounded-full mr-2 flex items-center justify-center text-white font-bold" style="background-color: {{ '#' . substr(md5(Auth::user()->name), 0, 6) }};">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>{{ Auth::user()->name }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }} <!-- This is where the content will be injected -->
                </main>
            </div>
        </div>
    </body>
</html>
