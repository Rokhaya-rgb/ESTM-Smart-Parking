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
                    <span class="font-display text-xl text-fg whitespace-nowrap">Parking ESTM</span>
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
        <div class="glow-blob animate-float-glow -left-24 top-1/4 h-80 w-80 bg-azure-500/25"></div>
        <div class="glow-blob animate-float-glow -right-24 bottom-1/4 h-96 w-96 bg-parking-free/15" style="animation-delay: -4s"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div>
                <h1 class="animate-fade-up delay-1 text-5xl md:text-7xl font-medium text-fg mb-6 leading-[1.05]">
                    Le parking de <span class="italic text-shimmer">l'ESTM</span>
                </h1>
                <p class="animate-fade-up delay-2 text-lg md:text-xl text-sand-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Consultez les places libres et occupées, puis retrouvez les derniers changements.
                </p>

                <div class="animate-fade-up delay-3 mb-10 flex flex-wrap items-center justify-center gap-3">
                    <span class="hero-stat"><span class="h-2 w-2 rounded-full bg-parking-free"></span><strong class="text-fg" data-count="{{ $availableSlots }}">{{ $availableSlots }}</strong> places libres</span>
                    <span class="hero-stat"><span class="h-2 w-2 rounded-full bg-parking-occupied"></span><strong class="text-fg" data-count="{{ $occupiedSlots }}">{{ $occupiedSlots }}</strong> occupées</span>
                    <span class="hero-stat">sur <strong class="text-fg" data-count="{{ $totalSlots }}">{{ $totalSlots }}</strong> places</span>
                </div>

                <div class="animate-fade-up delay-4 flex flex-col sm:flex-row gap-3 justify-center">
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
            <div class="text-center mb-16 reveal">
                <p class="eyebrow mb-4">En bref</p>
                <h2 class="text-4xl md:text-5xl font-medium text-fg mb-4">
                    Le parking, simplement
                </h2>
                <p class="text-lg text-sand-300 max-w-2xl mx-auto">
                    Les informations utiles pour trouver une place et suivre son état.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="surface-card reveal spot p-8 rounded-2xl">
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

                <div class="surface-card reveal spot p-8 rounded-2xl">
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

                <div class="surface-card reveal spot p-8 rounded-2xl">
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

    <!-- Comment ça marche -->
    <section class="relative overflow-hidden bg-page py-24 border-t border-fg/5">
        <div class="glow-blob left-1/2 top-0 h-72 w-[36rem] -translate-x-1/2 bg-azure-500/10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 reveal">
                <p class="eyebrow mb-4">Du terrain à l'écran</p>
                <h2 class="text-4xl md:text-5xl font-medium text-fg mb-4">Une maquette connectée</h2>
                <p class="text-lg text-sand-300 max-w-2xl mx-auto">
                    Les capteurs de la maquette envoient leurs mesures en temps réel jusqu'à ce tableau de bord.
                </p>
            </div>

            <!-- Scène animée : une voiture entre, la barrière se lève, le capteur de la place passe au rouge -->
            <div class="surface-panel reveal rounded-2xl p-4 sm:p-6 mb-8">
                <svg class="parking-scene" viewBox="0 0 960 300" role="img"
                     aria-label="Animation : une voiture passe la barrière, se gare sur la place A-02 dont le capteur passe au rouge, puis repart.">
                    <defs>
                        <g id="ps-car">
                            <rect class="ps-wheel" x="-34" y="-29" width="20" height="7" rx="2"/>
                            <rect class="ps-wheel" x="16" y="-29" width="20" height="7" rx="2"/>
                            <rect class="ps-wheel" x="-34" y="22" width="20" height="7" rx="2"/>
                            <rect class="ps-wheel" x="16" y="22" width="20" height="7" rx="2"/>
                            <rect x="-48" y="-24" width="96" height="48" rx="15" fill="currentColor"/>
                            <rect x="-40" y="-17" width="22" height="34" rx="6" fill="rgb(0 0 0 / 0.14)"/>
                            <rect class="ps-glass" x="-12" y="-19" width="36" height="38" rx="9"/>
                            <rect class="ps-light" x="41" y="-17" width="6" height="8" rx="2"/>
                            <rect class="ps-light" x="41" y="9" width="6" height="8" rx="2"/>
                        </g>
                    </defs>

                    <!-- Chaussée et marquage central -->
                    <rect class="ps-road" x="0" y="164" width="960" height="132" rx="16"/>
                    <line class="ps-lane" x1="0" y1="236" x2="960" y2="236"/>

                    <!-- Places -->
                    @foreach ([190, 370, 550, 730] as $i => $cx)
                        <rect class="ps-slot" x="{{ $cx - 66 }}" y="18" width="132" height="116" rx="12"/>
                        <text class="ps-label" x="{{ $cx }}" y="156">A-0{{ $i + 1 }}</text>
                    @endforeach
                    <rect class="ps-tint ps-tint-2" x="304" y="18" width="132" height="116" rx="12"/>
                    <rect class="ps-tint-occ" x="664" y="18" width="132" height="116" rx="12"/>

                    <!-- Voiture déjà garée sur A-04 -->
                    <g transform="translate(730 78) rotate(-90)"><use href="#ps-car" style="color:#f2b84b"/></g>

                    <!-- Voyants des capteurs -->
                    <circle class="ps-led-free" cx="190" cy="8" r="6"/>
                    <circle class="ps-led-free ps-led-2" cx="370" cy="8" r="6"/>
                    <circle class="ps-led-free" cx="550" cy="8" r="6"/>
                    <circle class="ps-led-occ" cx="730" cy="8" r="6"/>

                    <!-- Barrière d'entrée -->
                    <g transform="translate(110 240)">
                        <g class="ps-arm">
                            <rect x="-4" y="-62" width="8" height="62" rx="3" fill="#e5e7eb"/>
                            <rect x="-4" y="-62" width="8" height="12" fill="#e07a6f"/>
                            <rect x="-4" y="-38" width="8" height="12" fill="#e07a6f"/>
                            <rect x="-4" y="-14" width="8" height="12" fill="#e07a6f"/>
                        </g>
                        <rect x="-9" y="-6" width="18" height="24" rx="5" fill="#1b2a41"/>
                    </g>

                    <!-- Voitures en mouvement -->
                    <g class="ps-car1"><use href="#ps-car" style="color:#5f98ee"/></g>
                    <g class="ps-car3"><use href="#ps-car" style="color:#5fc9a0"/></g>
                </svg>
            </div>

            <!-- Chaîne de transmission -->
            <div class="flow reveal mb-14">
                @php
                    $nodes = [
                        ['Capteurs', 'M9.348 14.652a3.75 3.75 0 0 1 0-5.304m5.304 0a3.75 3.75 0 0 1 0 5.304m-7.425 2.121a6.75 6.75 0 0 1 0-9.546m9.546 0a6.75 6.75 0 0 1 0 9.546M5.106 18.894c-3.808-3.807-3.808-9.98 0-13.788m13.788 0c3.808 3.807 3.808 9.98 0 13.788M12 12h.008v.008H12V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z'],
                        ['ESP32', 'M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z'],
                        ['Mosquitto', 'M5.25 14.25h13.5m-13.5 0a3 3 0 0 1-3-3m3 3a3 3 0 1 0 0 6h13.5a3 3 0 1 0 0-6m-16.5-3a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3m-19.5 0a4.5 4.5 0 0 1 .9-2.7L5.737 5.1a3.375 3.375 0 0 1 2.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 0 1 .9 2.7m0 0a3 3 0 0 1-3 3m0 3h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Zm-3 6h.008v.008h-.008v-.008Zm0-6h.008v.008h-.008v-.008Z'],
                        ['Base de données', 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125'],
                        ['Tableau de bord', 'M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25'],
                    ];
                @endphp
                @foreach ($nodes as $i => [$label, $path])
                    <div class="flow-node">
                        <span><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/></svg></span>
                        {{ $label }}
                    </div>
                    @if (! $loop->last)<div class="flow-line" style="animation-delay: -{{ $i * 0.22 }}s"></div>@endif
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="surface-panel reveal spot rounded-2xl p-8">
                    <div class="step-number mb-5">1</div>
                    <h3 class="text-xl font-medium text-fg mb-2">Détection</h3>
                    <p class="text-sand-300">Des capteurs infrarouges repèrent chaque véhicule garé, et des capteurs à l'entrée et à la sortie comptent les passages.</p>
                </div>
                <div class="surface-panel reveal spot rounded-2xl p-8">
                    <div class="step-number mb-5">2</div>
                    <h3 class="text-xl font-medium text-fg mb-2">Transmission</h3>
                    <p class="text-sand-300">Un ESP32 publie ces informations par Wi-Fi vers un serveur MQTT, plusieurs fois par seconde.</p>
                </div>
                <div class="surface-panel reveal spot rounded-2xl p-8">
                    <div class="step-number mb-5">3</div>
                    <h3 class="text-xl font-medium text-fg mb-2">Affichage</h3>
                    <p class="text-sand-300">L'application enregistre chaque changement et met le tableau de bord à jour automatiquement.</p>
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
