<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Parking ESTM') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Styles et Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    <style>
        .glass-effect {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            background: rgba(15, 23, 42, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .text-shadow {
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 overflow-x-hidden">
    
    <!-- Navigation Header -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-effect">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="p-2">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3 4.5 6v5.5c0 4.7 3.1 8.7 7.5 10.5 4.4-1.8 7.5-5.8 7.5-10.5V6L12 3Z"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-semibold text-white">Parking ESTM</span>
                </div>

                <!-- Navigation Links -->
                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" 
                               class="bg-white/15 text-white px-6 py-2 rounded-lg font-medium hover:bg-white/25 transition-colors duration-300">
                                   Tableau de bord
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="text-white hover:text-amber-200 px-4 py-2 rounded-lg font-medium transition-colors duration-300">
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
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 text-shadow">
                    Le parking de <span class="text-amber-200">l'ESTM</span>
                </h1>
                <p class="text-xl md:text-2xl text-white mb-8 max-w-3xl mx-auto leading-relaxed">
                    Consultez les places libres et occupées, puis retrouvez les derniers changements.
                </p>
                <p class="text-lg text-white/85 mb-12 max-w-2xl mx-auto">
                    École Supérieure de Technologie et de Management
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                           class="bg-amber-200 text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-amber-100 transition-colors duration-200 shadow-lg">
                            Tableau de bord
                        </a>
                        <a href="{{ url('/history') }}"
                           class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-gray-900 transition-all duration-300 shadow-xl">
                            Voir l’historique
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="bg-amber-200 text-gray-900 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-amber-100 transition-colors duration-200 shadow-lg">
                            Commencer
                        </a>
                        <a href="#features"
                           class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-gray-900 transition-all duration-300 shadow-xl">
                            Découvrir
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Le parking, en bref
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Les informations utiles pour trouver une place et suivre son état.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="surface-card border border-gray-200 p-8 rounded-xl shadow-sm">
                    <div class="bg-amber-100 w-12 h-12 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">État des places</h3>
                    <p class="text-gray-600 mb-4">
                        Consultez les places libres et occupées depuis le tableau de bord, mis à jour automatiquement.
                    </p>
                </div>

                <div class="surface-card border border-gray-200 p-8 rounded-xl shadow-sm">
                    <div class="bg-amber-100 w-12 h-12 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Historique</h3>
                    <p class="text-gray-600 mb-4">
                        Retrouvez les changements d’état enregistrés, avec la date et l’heure.
                    </p>
                </div>

                <div class="surface-card border border-gray-200 p-8 rounded-xl shadow-sm">
                    <div class="bg-amber-100 w-12 h-12 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16 0v-2a4 4 0 00-3-3.87M14 3.13a4 4 0 010 7.75M14 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Accès au service</h3>
                    <p class="text-gray-600 mb-4">
                        Connectez-vous pour consulter le tableau de bord et les données du parking.
                    </p>
                </div>
            </div>
        </div>
    </section>



    <!-- Footer -->
    <footer class="bg-slate-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="p-1">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3 4.5 6v5.5c0 4.7 3.1 8.7 7.5 10.5 4.4-1.8 7.5-5.8 7.5-10.5V6L12 3Z"></path>
                            </svg>
                        </div>
                        <span class="text-lg font-semibold">Parking ESTM</span>
                    </div>
                    <p class="text-sm text-slate-300">Parking de l’École Supérieure de Technologie et de Management.</p>
                </div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-slate-300 hover:text-white">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-slate-300 hover:text-white">Connexion</a>
                @endauth
            </div>
            <p class="mt-6 border-t border-slate-700 pt-5 text-sm text-slate-400">
                &copy; {{ date('Y') }} ESTM
            </p>
        </div>
    </footer>

    <!-- Smooth Scrolling Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
