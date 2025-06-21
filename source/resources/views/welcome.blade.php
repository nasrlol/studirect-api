<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Backend</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Vite or fallback -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
                background-color: #FDFDFC;
                color: #1b1b18;
                margin: 0;
                padding: 2rem;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            @media (prefers-color-scheme: dark) {
                body {
                    background-color: #0a0a0a;
                    color: #EDEDEC;
                }

                a {
                    color: #EDEDEC;
                }
            }

            nav {
                display: flex;
                gap: 1rem;
                margin-bottom: 2rem;
            }

            a {
                text-decoration: none;
                border: 1px solid transparent;
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                border-radius: 0.25rem;
                transition: border-color 0.2s ease;
            }

            a:hover {
                border-color: #19140035;
            }

            .bordered {
                border-color: #19140035;
            }

            @media (prefers-color-scheme: dark) {
                .bordered {
                    border-color: #3E3E3A;
                }

                a:hover {
                    border-color: #62605b;
                }
            }
        </style>
    @endif
</head>
<body>
@if (Route::has('login'))
    <nav>
        @auth
            <a href="{{ url('/dashboard') }}" class="bordered">Dashboard</a>
        @else
            <a href="{{ route('login') }}">Log in</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="bordered">Register</a>
            @endif
        @endauth
    </nav>
@endif

<main>
    <h1 style="font-size: 1.5rem; margin-bottom: 1rem;">Backend is running</h1>
    <p style="color: #706f6c;">Everything is set up correctly.</p>
</main>
</body>
</html>
