<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Parking ESTM')</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="antialiased">
        <!-- Background Image -->
        <div class="bg-image"></div>
        
        <!-- Glass Overlay -->
        <div class="glass-overlay"></div>

        <!-- Content -->
        <div class="content-container">
            <!-- Navigation -->
            <nav class="nav-glass fixed w-full z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center">
                            <a href="/" class="text-2xl font-bold text-white">{{ config('app.name', 'Parking ESTM') }}</a>
                        </div>
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-white hover:text-indigo-200">Tableau de bord</a>
                                <a href="{{ url('/slot-history') }}" class="text-white hover:text-indigo-200">Historique</a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-white hover:text-indigo-200">
                                        Déconnexion
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-white hover:text-indigo-200">Connexion</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="py-20">
                @yield('content')
                {{ $slot ?? '' }}
            </main>
        </div>
        @livewireScripts
    </body>
</html>
