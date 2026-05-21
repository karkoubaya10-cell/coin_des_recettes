<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Coin des recettes') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .app-body {
            font-family: "Montserrat", sans-serif;
            color: #333;
            background: #fff;
            padding-top: var(--navbar-height, 120px) !important;
        }

        .mini-navbar {
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 2000 !important;
            background: #FEEAE6;
            border-bottom: 1px solid #f2c8bd;
            box-shadow: none;
            transition: box-shadow 0.2s ease;
        }

        .mini-navbar.is-scrolled {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .mini-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: "Playfair Display", serif;
            letter-spacing: 0.1em;
            font-size: 1.25rem;
            font-weight: 800;
            color: #333;
            text-decoration: none;
        }

        .mini-logo-icon {
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
        }

        .mini-logo-text {
            line-height: 1;
        }

        .mini-link {
            color: #333 !important;
            font-size: 0.86rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .mini-link:hover {
            color: #E97451 !important;
        }

        .mini-btn {
            border: 1px solid #E97451;
            color: #E97451;
            border-radius: 999px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .mini-btn:hover {
            background: #E97451;
            color: #fff;
        }

        .mini-footer {
            background: linear-gradient(180deg, #fff6f3 0%, #feeae6 100%);
            border-top: 1px solid #f2c8bd;
        }

        .mini-footer-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, #eab8aa 20%, #eab8aa 80%, transparent 100%);
            margin-bottom: 1.2rem;
        }

        .mini-footer-title {
            font-family: "Playfair Display", serif;
            color: #5B2E91;
            font-size: 1.1rem;
            margin-bottom: 0.9rem;
        }

        .mini-footer-note {
            color: #5f3b35;
            font-weight: 500;
            letter-spacing: 0.01em;
            line-height: 1.7;
            max-width: 58ch;
        }

        .mini-footer-panel {
            border: 1px solid #f1cbc1;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.58);
            padding: 1.25rem 1rem;
            backdrop-filter: blur(2px);
        }

        .mini-footer-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.6rem;
        }

        .mini-footer-link {
            color: #5f3b35;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            padding: 0.5rem 0.85rem;
            border: 1px solid #efccc1;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.75);
            display: inline-flex;
            align-items: center;
        }

        .mini-footer-link:hover {
            color: #E97451;
            border-color: #e7a999;
            background: #fff;
            transform: translateY(-1px);
        }

        .mini-footer-bottom {
            border-top: 1px solid rgba(234, 184, 170, 0.5);
        }
    </style>
</head>
<body class="app-body">
    <nav id="miniNavbar" class="navbar navbar-expand-lg mini-navbar fixed-top">
        <div class="container flex-column py-2">
            <a class="navbar-brand mini-logo mx-auto mb-2 text-center" href="{{ route('recettes.liste') }}">
                <x-brand-mark class="mini-logo-icon" />
                <span class="mini-logo-text">{{ config('app.name', 'Coin des recettes') }}</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarLinks" aria-controls="mainNavbarLinks" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center w-100 mt-2" id="mainNavbarLinks">
                <ul class="navbar-nav align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link mini-link" href="{{ route('recettes.liste') }}#titre-liste-recettes">{{ __('messages.toutes_recettes') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mini-link" href="{{ route('recettes.ajouter.form') }}">{{ __('messages.ajouter_recette') }}</a>
                    </li>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item dropdown">
                                <a class="nav-link mini-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ __('messages.admin') }}
                                </a>
                                <ul class="dropdown-menu shadow-sm border-0">
                                    <li><a class="dropdown-item" href="{{ route('xml.index') }}">{{ __('messages.xml') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('stats.procedure') }}">{{ __('messages.stats') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('stats.graphes') }}">{{ __('messages.graphes') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('archives.index') }}">{{ __('messages.archives') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('favoris.admin') }}">{{ __('messages.liste_favoris') }}</a></li>
                                </ul>
                            </li>
                        @endif
                    @endauth
                    <li class="nav-item dropdown">
                        <a class="nav-link mini-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('messages.langue') }}
                        </a>
                        <ul class="dropdown-menu shadow-sm border-0">
                            <li><a class="dropdown-item" href="{{ url('lang/fr') }}">FR</a></li>
                            <li><a class="dropdown-item" href="{{ url('lang/en') }}">EN</a></li>
                        </ul>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link mini-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('messages.profil') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('recettes.mes') }}">{{ __('messages.mes_recettes') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('favoris.liste') }}">{{ __('messages.mes_favoris') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item">
                            <a class="btn btn-sm mini-btn px-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-sm mini-btn px-3" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Titre optionnel pour les pages Breeze comme Dashboard et Profile. --}}
    @isset($header)
        <div class="container pt-4">
            <div class="card border-0 shadow-sm page-header-card">
                <div class="card-body">
                    {{ $header }}
                </div>
            </div>
        </div>
    @endisset

    <main class="main-content py-4 py-lg-5">
        <div class="container">
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </main>

    <footer class="mini-footer mt-5">
        <div class="container py-4 py-lg-5">
            <div class="mini-footer-divider"></div>
            <div class="row g-4 justify-content-center text-center">
                <div class="col-12 col-lg-10">
                    <h4 class="mini-footer-title mb-2">{{ __('messages.app_name') }}</h4>
                    <p class="mini-footer-note mx-auto mb-0">{{ __('messages.footer_note') }}</p>
                </div>
                <div class="col-12 col-lg-10">
                    <div class="mini-footer-panel">
                        <h5 class="mini-footer-title">{{ __('messages.liens_utiles') }}</h5>
                        <ul class="mini-footer-list">
                            <li><a class="mini-footer-link" href="{{ route('recettes.liste') }}">{{ __('messages.accueil') }}</a></li>
                            <li><a class="mini-footer-link" href="{{ route('recettes.liste') }}#titre-liste-recettes">{{ __('messages.toutes_recettes') }}</a></li>
                            <li><a class="mini-footer-link" href="{{ route('recettes.ajouter.form') }}">{{ __('messages.ajouter_recette') }}</a></li>
                            @auth
                                <li><a class="mini-footer-link" href="{{ route('recettes.mes') }}">{{ __('messages.mes_recettes') }}</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mini-footer-bottom text-center mt-4 pt-3">
                <div class="small text-muted d-inline-flex align-items-center gap-2">
                    <x-brand-mark style="width:18px;height:18px;" />
                    <span>&copy; 2026 {{ __('messages.app_name') }}</span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const miniNavbar = document.getElementById('miniNavbar');
        const updateNavbarOffset = () => {
            document.documentElement.style.setProperty('--navbar-height', `${miniNavbar.offsetHeight}px`);
        };
        const handleNavbarShadow = () => {
            miniNavbar.classList.toggle('is-scrolled', window.scrollY > 6);
        };
        window.addEventListener('scroll', handleNavbarShadow);
        window.addEventListener('resize', updateNavbarOffset);
        updateNavbarOffset();
        handleNavbarShadow();
    </script>
</body>
</html>
