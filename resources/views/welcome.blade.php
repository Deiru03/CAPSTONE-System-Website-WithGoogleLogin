<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome to IQA ClearVault</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                background: linear-gradient(45deg, #1e3a8a, #3b82f6, #e0f7fa);
                background-size: 400% 400%;
                animation: gradientBG 15s ease infinite;
                margin: 0;
                font-family: 'Figtree', Arial, sans-serif;
                height: 100vh;
                overflow-x: hidden;
            }

            @keyframes gradientBG {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .header2 {
                display: flex;
                align-items: center;
                padding: 20px;
                color: white;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
                animation: fadeInDown 1s ease-out;
            }

            .logo {
                width: 100px;
                height: auto;
                margin-right: 20px;
                transition: transform 0.3s ease;
            }

            .logo:hover {
                transform: scale(1.1);
            }

            .container {
                text-align: left;
                padding: 50px 70px;
                min-height: 80vh;
                max-width: 1200px;
                margin: 0 auto;
                animation: fadeIn 1s ease-out;
                position: relative;
                z-index: 1;
            }

            .header {
                margin-bottom: 50px;
            }

            h1 {
                font-size: 5rem;
                color: white;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
                margin-bottom: 20px;
                animation: slideInLeft 1s ease-out;
            }

            p {
                font-size: 1.5rem;
                color: hsl(0, 0%, 90%);
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
                animation: slideInRight 1s ease-out;
            }

            .button-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                margin-top: 40px;
                animation: fadeInUp 1s ease-out;
            }

            .button1, .button-google {
                padding: 12px 24px;
                background-color: rgba(255, 255, 255, 0.1);
                color: white;
                border: 2px solid white;
                border-radius: 30px;
                text-decoration: none;
                font-size: 1rem;
                transition: all 0.3s ease;
                backdrop-filter: blur(5px);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .button1:hover, .button-google:hover {
                background-color: white;
                color: #1e40af;
                transform: translateY(-3px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }

            .button-google img {
                width: 20px;
                height: 20px;
                margin-right: 10px;
            }

            footer {
                text-align: center;
                padding: 20px;
                color: white;
                font-size: 0.9rem;
                background-color: rgba(0, 0, 0, 0.1);
                backdrop-filter: blur(5px);
                position: relative;
                z-index: 1;
            }

            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
            @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
            @keyframes slideInLeft { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
            @keyframes slideInRight { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }

            .floating-items {
                position: absolute;
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
        <main>
            <div class="header2">
                <img src="{{ asset('images/OMSCLogo.png') }}" alt="OMSC Logo" class="logo" />
                <h3>OCCIDENTAL MINDORO STATE COLLEGE</h3>
            </div>
            <div class="container">
                <div class="header">
                    <h1>IQA ClearVault</h1>
                    <p>Occidental Mindoro State College's secure vault for Institutional Quality Assurance data banking and clearance management</p>
                </div>
                @if (Route::has('login'))
                    <div class="button-container">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="button1">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="button1">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="button1">Register</a>
                            @endif
                            <a href="{{ route('google.login') }}" class="button-google">
                                <img src="https://www.google.com/favicon.ico" alt="Google logo" />
                                Login with Google
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </main>
        <footer>
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </body>
</html>
