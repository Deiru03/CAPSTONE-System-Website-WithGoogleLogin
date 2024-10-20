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
    </body>
</html>
