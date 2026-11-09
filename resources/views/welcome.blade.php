<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Parking ESTM') }}</title>
    <link rel="icon" href="/favicon.ico" sizes="48x48">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|fraunces:400,500,600&display=swap" rel="stylesheet" />

    @include('partials.theme-script')

    <!-- Styles et Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-page overflow-x-hidden">

    <!-- Navigation Header -->
    <nav class="app-nav fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <img src="/favicon.svg" alt="" class="w-7 h-7 rounded-md">
                    <span class="font-display text-xl text-fg">Parking ESTM</span>
                </div>

                <!-- Navigation Links -->
                @if (Route::has('login'))
                    <div class="flex items-center space-x-2">
                        @include('partials.theme-toggle')
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-secondary">
                                Tableau de bord
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn-secondary">
                                Connexion
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="parking-background min-h-screen flex items-center justify-center relative overflow-hidden pt-16">
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div>
                <p class="eyebrow mb-6">École Supérieure de Technologie et de Management</p>
                <h1 class="text-5xl md:text-7xl font-medium text-fg mb-6 leading-[1.05]">
                    Le parking de <span class="italic text-azure-300">l'ESTM</span>
                </h1>
                <p class="text-lg md:text-xl text-sand-100 mb-12 max-w-2xl mx-auto leading-relaxed">
                    Consultez les places libres et occupées, puis retrouvez les derniers changements.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary px-8 py-3.5 text-base">
                            Tableau de bord
                        </a>
                        <a href="{{ url('/history') }}" class="btn-ghost px-8 py-3.5 text-base">
                            Voir l’historique
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary px-8 py-3.5 text-base">
                            Commencer
                        </a>
                        <a href="#features" class="btn-ghost px-8 py-3.5 text-base">
                            Découvrir
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-page-alt border-t border-fg/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="eyebrow mb-4">En bref</p>
                <h2 class="text-4xl md:text-5xl font-medium text-fg mb-4">
                    Le parking, simplement
                </h2>
                <p class="text-lg text-sand-300 max-w-2xl mx-auto">
                    Les informations utiles pour trouver une place et suivre son état.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="surface-card p-8 rounded-2xl">
                    <div class="bg-azure-400/15 w-12 h-12 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-azure-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-fg mb-3">État des places</h3>
                    <p class="text-sand-300">
                        Consultez les places libres et occupées depuis le tableau de bord, mis à jour automatiquement.
                    </p>
                </div>

                <div class="surface-card p-8 rounded-2xl">
                    <div class="bg-azure-400/15 w-12 h-12 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-azure-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-fg mb-3">Historique</h3>
                    <p class="text-sand-300">
                        Retrouvez les changements d’état enregistrés, avec la date et l’heure.
                    </p>
                </div>

                <div class="surface-card p-8 rounded-2xl">
                    <div class="bg-azure-400/15 w-12 h-12 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-azure-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-3-3.87M14 3.13a4 4 0 010 7.75M14 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-fg mb-3">Accès au service</h3>
                    <p class="text-sand-300">
                        Connectez-vous pour consulter le tableau de bord et les données du parking.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-page border-t border-fg/5 text-fg py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                <div>
                    <div class="flex items-center space-x-3 mb-3">
                        <img src="/favicon.svg" alt="" class="w-6 h-6 rounded-md">
                        <span class="font-display text-lg">Parking ESTM</span>
                    </div>
                    <p class="text-sm text-sand-300">Parking de l’École Supérieure de Technologie et de Management.</p>
                </div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-sand-300 hover:text-fg">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-sand-300 hover:text-fg">Connexion</a>
                @endauth
            </div>
            <p class="mt-8 border-t border-fg/10 pt-5 text-sm text-sand-500">
                &copy; {{ date('Y') }} ESTM
            </p>
        </div>
    </footer>
</body>
</html>
