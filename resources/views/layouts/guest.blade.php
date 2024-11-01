<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'OMSC') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                background: linear-gradient(45deg, #1e3a8a, #3b82f6, #e0f7fa);
                background-size: 400% 400%;
                animation: gradientBG 15s ease infinite;
                font-family: 'Figtree', Arial, sans-serif;
                overflow-x: hidden;
            }

            @keyframes gradientBG {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .floating-items {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 0;
            }

            .floating-item {
                position: absolute;
                display: block;
                list-style: none;
                animation: float 25s linear infinite;
                bottom: -150px;
                font-size: 24px;
                color: rgba(255, 255, 255, 0.3);
            }

            .floating-item:nth-child(1) { left: 25%; animation-delay: 0s; }
            .floating-item:nth-child(2) { left: 10%; animation-delay: 2s; animation-duration: 12s; }
            .floating-item:nth-child(3) { left: 70%; animation-delay: 4s; }
            .floating-item:nth-child(4) { left: 40%; animation-delay: 0s; animation-duration: 18s; }
            .floating-item:nth-child(5) { left: 65%; animation-delay: 0s; }
            .floating-item:nth-child(6) { left: 75%; animation-delay: 3s; }
            .floating-item:nth-child(7) { left: 35%; animation-delay: 7s; }
            .floating-item:nth-child(8) { left: 50%; animation-delay: 15s; animation-duration: 45s; }
            .floating-item:nth-child(9) { left: 20%; animation-delay: 2s; animation-duration: 35s; }
            .floating-item:nth-child(10) { left: 85%; animation-delay: 0s; animation-duration: 11s; }

            @keyframes float {
                0% {
                    transform: translateY(0) rotate(0deg);
                    opacity: 1;
                }
                100% {
                    transform: translateY(-1000px) rotate(720deg);
                    opacity: 0;
                }
            }

            .content-wrapper {
                position: relative;
                z-index: 1;
            }

            .logo-container {
                animation: fadeInDown 1s ease-out;
            }

            .logo {
                transition: transform 0.3s ease;
            }

            .logo:hover {
                transform: scale(1.1);
            }

            .form-container {
                animation: fadeIn 1s ease-out;
            }

            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        </style>
    </head>
    <body>
        <div class="floating-items">
            <li class="floating-item">📚</li>
            <li class="floating-item">🎓</li>
            <li class="floating-item">✏️</li>
            <li class="floating-item">🖋️</li>
            <li class="floating-item">📝</li>
            <li class="floating-item">🔬</li>
            <li class="floating-item">🧪</li>
            <li class="floating-item">📐</li>
            <li class="floating-item">🖥️</li>
            <li class="floating-item">🧮</li>
        </div>
        <div class="min-h-screen flex content-wrapper">
            <!-- Left side - Logo and College Name -->
            <div class="w-1/2 flex flex-col justify-center items-center p-12 logo-container">
                <a href="/" class="group relative transition-transform duration-300 ease-in-out hover:scale-105">
                    <img src="{{ asset('images/OMSCLogo.png') }}" alt="OMSC Logo" class="w-48 h-48 shadow-lg rounded-full logo" />
                    <span class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 px-2 py-1 bg-white text-blue-600 text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-center whitespace-nowrap">Return to Home</span>
                </a>
                <h3 class="mt-8 text-3xl font-serif font-semibold text-white text-center text-shadow">OCCIDENTAL MINDORO STATE COLLEGE</h3>
            </div>

            <!-- Right side - Content -->
            <div class="w-1/2 flex items-center justify-center form-container">
                <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <!-- Loading Spinner -->
        <div id="loadingSpinner" class="fixed inset-0 flex items-center justify-center bg-gray-900/90 backdrop-blur-sm hidden z-50">
            <div class="relative flex flex-col items-center">
                <!-- Logo Container with Animation -->
                <div class="w-32 h-32 mb-8 relative animate-bounce">
                    <img src="{{ asset('images/OMSCLogo.png') }}" alt="OMSC Logo" class="w-full h-full object-contain animate-pulse">
                    <!-- Spinning ring around logo -->
                    <div class="absolute inset-0 rounded-full border-8 border-transparent border-t-indigo-500 border-r-indigo-500 animate-spin"></div>
                </div>

                <!-- Animated Loading Text -->
                <div class="text-center">
                    <div class="flex items-center space-x-2">
                        <span class="text-white text-xl font-medium tracking-wider">
                            <span class="inline-block animate-pulse">C</span>
                            <span class="inline-block animate-pulse delay-75">l</span>
                            <span class="inline-block animate-pulse delay-100">e</span>
                            <span class="inline-block animate-pulse delay-150">a</span>
                            <span class="inline-block animate-pulse delay-200">r</span>
                            <span class="inline-block animate-pulse delay-300">V</span>
                            <span class="inline-block animate-pulse delay-400">a</span>
                            <span class="inline-block animate-pulse delay-500">u</span>
                            <span class="inline-block animate-pulse delay-600">l</span>
                            <span class="inline-block animate-pulse delay-700">t</span>
                        </span>
                    </div>
                    <div class="mt-2 text-indigo-300 loading-dots">Loading</div>
                </div>

                <!-- Progress bar -->
                <div class="w-48 h-1 bg-gray-700 rounded-full mt-4 overflow-hidden">
                    <div class="progress-bar h-full w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-500 background-animate"></div>
                </div>
            </div>
        </div>

        <style>
            .loading-dots::after {
                content: '';
                animation: dots 1.5s infinite;
            }

            @keyframes dots {
                0%, 20% { content: '.'; }
                40% { content: '..'; }
                60% { content: '...'; }
                80%, 100% { content: ''; }
            }

            .background-animate {
                background-size: 400%;
                animation: AnimateBackground 1s ease infinite;
            }

            @keyframes AnimateBackground {
                0%, 100% {
                    background-position: 0% 50%;
                }
                50% {
                    background-position: 100% 50%;
                }
            }

            .delay-75 { animation-delay: 75ms; }
            .delay-100 { animation-delay: 100ms; }
            .delay-150 { animation-delay: 150ms; }
            .delay-200 { animation-delay: 200ms; }
            .delay-300 { animation-delay: 300ms; }
            .delay-400 { animation-delay: 400ms; }
            .delay-500 { animation-delay: 500ms; }
            .delay-600 { animation-delay: 600ms; }
            .delay-700 { animation-delay: 700ms; }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const loadingSpinner = document.getElementById('loadingSpinner');

                function showLoading() {
                    loadingSpinner.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Prevent scrolling while loading
                }

                function hideLoading() {
                    loadingSpinner.classList.add('hidden');
                    document.body.style.overflow = ''; // Restore scrolling
                }

                // Show loading spinner on page unload
                window.addEventListener('beforeunload', showLoading);

                // Hide loading spinner on page load
                window.addEventListener('load', hideLoading);

                // Add loading spinner for all form submissions
                document.querySelectorAll('form').forEach(form => {
                    form.addEventListener('submit', showLoading);
                });

                // Add loading spinner for all links that are not "#" or javascript:void(0)
                document.querySelectorAll('a').forEach(link => {
                    if (link.href && !link.href.includes('#') && !link.href.includes('javascript:void(0)')) {
                        link.addEventListener('click', showLoading);
                    }
                });
            });
        </script>
    </body>
</html>
