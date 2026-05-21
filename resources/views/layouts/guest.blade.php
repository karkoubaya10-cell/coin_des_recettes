<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Coin des recettes') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body {
                font-family: "Montserrat", sans-serif;
                background: #fcf9f7;
                color: #121212;
            }

            .guest-wrap {
                min-height: 100vh;
                background:
                    radial-gradient(circle at 12% 8%, rgba(123, 76, 201, 0.1), transparent 40%),
                    radial-gradient(circle at 88% 18%, rgba(212, 163, 115, 0.12), transparent 45%),
                    linear-gradient(180deg, #fcf9f7 0%, #f8f1ea 100%);
            }

            .guest-brand {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                font-family: "Playfair Display", serif;
                font-size: 1.45rem;
                font-weight: 700;
                color: #064420;
                letter-spacing: 0.03em;
                text-decoration: none;
            }

            .guest-brand-logo {
                width: 40px;
                height: 40px;
                flex: 0 0 40px;
            }

            .guest-card {
                width: 100%;
                max-width: 460px;
                margin-top: 1rem;
                padding: 1.2rem 1.2rem;
                background: #fff;
                border: 1px solid #eee;
                border-radius: 16px;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="guest-wrap flex flex-col justify-center items-center pt-8 pb-8 px-4">
            <div>
                <a href="{{ route('recettes.liste') }}" class="guest-brand">
                    <x-brand-mark class="guest-brand-logo" />
                    <span>{{ config('app.name', 'Coin des recettes') }}</span>
                </a>
            </div>

            <div class="guest-card">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
