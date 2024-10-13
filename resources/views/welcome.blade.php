<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome to DB&C System</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                background: linear-gradient(to bottom, #1e3a8a, #e0f7fa); /* Gradient from dark blue to light blue */
                margin: 0;
                font-family: Arial, sans-serif; /* Use Arial or sans-serif */
                height: 100vh; /* Ensure full viewport height */
            }

            .header2 {
                display: flex;
                align-items: center;
                margin-left: 20px; /* Adjust left position */
                margin-top: 20px; /* Adjust top position */
                color: white;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add shadow effect */
            }

            .logo {
                width: 100px; /* Adjust size as needed */
                height: auto; /* Maintain aspect ratio */
                margin-right: 10px; /* Space between logo and title */
                margin-left: 10px
            }

            .container {
                text-align: left; /* Align the text to the left */
                margin-left: 70px; /* Add left margin of 70px */
                padding: 10px; /* Add padding */
                min-height: 80vh; /* Full viewport height */
                width: 700px;
            }

            .header {
                margin-bottom: 10px; /* Space between header and buttons */
                margin-left: 70px; /* Add left margin of 70px */
                margin-top: 200px;
            }

            h1 {
                font-size: 80px; /* Large title */
                color: white; /* White color */
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add shadow effect */
                margin-bottom: 10px; /* Reduce space between h1 and p */
            }

            p {
                font-size: 20px; /* Subtitle size */
                color: hsl(0, 0%, 75%); /* Gray color for subtitle */
                margin-top: 5; /* Remove top margin for p */
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add shadow effect */
            }

            .button1 {
                display: inline-block;
                padding: 12px 24px; /* Moderate padding */
                margin: 10px;
                background-color: transparent; /* Dark blue background */
                color: #1e40af; /* White text */
                border: 2px solid #1e40af;
                border-radius: 4px; /* Slightly rounded corners */
                text-decoration: none; /* Remove underline */
                font-size: 14px; /* Font size */
                transition: background-color 0.3s, color 0.3s; /* Smooth transition for hover effects */
            }

            .button1:hover {
                background-color: #3b82f6; /* Lighter blue on hover */
                color: white;
            }

            .position-bottom-left {
                position: fixed; /* Fix the position */
                bottom: 50px; /* Adjust as needed */
                left: 50px; /* Adjust as needed */
            }

            .button-google {
                display: inline-block;
                padding: 10px 20px; /* Reduced padding */
                margin: 8px; /* Slightly reduced margin */
                background-color: transparent; /* Google blue */
                color: #1e40af;
                border: 2px solid #1e40af;
                border-radius: 4px;
                text-decoration: none;
                font-size: 14px; /* Slightly reduced font size */
                transition: background-color 0.3s, color 0.3s;
                display: flex;
                align-items: center;
                width: 180px; /* Set a fixed width */
            }

            .button-google:hover {
                background-color: #357AE8;
                color: white; /* Slightly darker blue on hover */
            }

            .button-google img {
                width: 18px;
                height: 18px;
                margin-right: 10px;
            }
        </style>
    </head>
    <body>
        <main class="mt-6">
            <div class="header2">
                <img src="{{ asset('images/OMSCLogo.png') }}" alt="OMSC Logo" class="logo" />
                <h3 style="margin: 0;">OCCIDENTAL MINDORO STATE COLLEGE</h3>
            </div>
            <div class="container">
                <div class="header" style="transform: translateX(-10%);">
                    <h1>DB&C System</h1>
                    <p>Data Banking and Clearance Checklist System for the College of Art, Sciences, and Technology</p>
                </div>
                @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-1 justify-end left-50">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="button1">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="button1">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="button1">
                                    Register
                                </a>
                            @endif

                            <a href="{{ route('google.login') }}" class="button-google">
                                <img src="https://www.google.com/favicon.ico" alt="Google logo" />
                                Login with Google
                            </a>
                        @endauth
                    </nav>
                @endif
            </div>
        </main>
        <footer class="py-16 text-center text-sm text-black dark:text-white/70">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </body>
</html>
