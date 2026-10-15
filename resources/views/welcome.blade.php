<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Parking ESTM') }} - Système de Gestion Intelligent</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Styles et Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    <style>
        .bg-image {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/images/estm-parking.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(2px);
            z-index: -2;
        }

        .glass-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(3px);
            z-index: -1;
        }

        .content-container {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .nav-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Background Image -->
    <div class="bg-image"></div>
    
    <!-- Glass Overlay -->
    <div class="glass-overlay"></div>

    <!-- Content -->
    <div class="min-h-screen content-container">
        <!-- Navigation -->
        <nav class="nav-glass fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="p-2 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white text-shadow">{{ config('app.name', 'Parking ESTM') }}</span>
                    </div>

                    <!-- Navigation Links -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-white hover:text-blue-100 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Tableau de bord</a>
                            <a href="{{ url('/slot-history') }}" class="text-white hover:text-blue-100 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Historique</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-blue-100 px-3 py-2 rounded-md text-sm font-medium transition duration-300">Connexion</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="min-h-screen flex items-center justify-center relative overflow-hidden pt-16">
            <!-- Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full animate-float"></div>
                <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white opacity-5 rounded-full animate-pulse-slow"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center content-wrapper">
                <div class="animate-fade-in">
                    <h1 class="text-5xl md:text-7xl font-bold mb-6 text-shadow text-white">
                        Parking Intelligent
                    </h1>                    <p class="text-xl md:text-2xl text-indigo-600 font-semibold mb-8 max-w-3xl mx-auto leading-relaxed">
                        Système de gestion avancé pour l'École Supérieure de Technologie de Management
                    </p>
                    
                    <p class="text-xl md:text-2xl text-indigo-600 font-semibold mb-8 max-w-3xl mx-auto leading-relaxed">
                        Votre place est assurée, votre temps est précieux
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="{{ url('/dashboard') }}" 
                            class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-all duration-300 shadow-xl transform hover:scale-105">
                            Accéder au Dashboard
                            </a>
                            <a href="{{ url('/history') }}" 
                            class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-indigo-600 transition-all duration-300 shadow-xl">
                            Voir l'Historique
                            </a>
                        @else
                            <a href="{{ route('register') }}" 
                            class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-all duration-300 shadow-xl transform hover:scale-105">
                            Commencer
                            </a>
                            <a href="#features" 
                            class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-indigo-600 transition-all duration-300 shadow-xl">
                            Découvrir
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        Fonctionnalités <span class="text-indigo-600">Avancées</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Une solution complète pour la gestion moderne du stationnement universitaire
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1: Dashboard Temps Réel -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="bg-blue-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Dashboard Temps Réel</h3>
                        <p class="text-gray-600 mb-4">
                            Surveillance instantanée de toutes les places de parking avec mise à jour automatique toutes les 2 secondes.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li>• Grille interactive des places</li>
                            <li>• Statistiques en direct</li>
                            <li>• Indicateurs visuels colorés</li>
                        </ul>
                    </div>

                    <!-- Feature 2: Historique Détaillé -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-100 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="bg-green-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Historique Complet</h3>
                        <p class="text-gray-600 mb-4">
                            Suivi détaillé de tous les événements de stationnement avec pagination et filtres avancés.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li>• Journaux d'événements</li>
                            <li>• Recherche et filtrage</li>
                            <li>• Export des données</li>
                        </ul>
                    </div>

                    <!-- Feature 3: API ESP32 -->
                    <div class="bg-gradient-to-br from-purple-50 to-violet-100 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="bg-purple-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">API IoT Intégrée</h3>
                        <p class="text-gray-600 mb-4">
                            Interface REST complète pour l'intégration avec les capteurs ESP32 et autres dispositifs IoT.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li>• Endpoints RESTful</li>
                            <li>• Authentification sécurisée</li>
                            <li>• Documentation API</li>
                        </ul>
                    </div>

                    <!-- Feature 4: Authentification -->
                    <div class="bg-gradient-to-br from-orange-50 to-red-100 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="bg-red-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Sécurité Avancée</h3>
                        <p class="text-gray-600 mb-4">
                            Système d'authentification robuste avec gestion des rôles et protection des données.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li>• Connexion sécurisée</li>
                            <li>• Gestion des sessions</li>
                            <li>• Protection CSRF</li>
                        </ul>
                    </div>

                    <!-- Feature 5: Interface Moderne -->
                    <div class="bg-gradient-to-br from-teal-50 to-cyan-100 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="bg-teal-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Design Responsive</h3>
                        <p class="text-gray-600 mb-4">
                            Interface utilisateur moderne et intuitive, optimisée pour tous les appareils.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li>• Design mobile-first</li>
                            <li>• Animations fluides</li>
                            <li>• UX optimisée</li>
                        </ul>
                    </div>

                    <!-- Feature 6: Livewire -->
                    <div class="bg-gradient-to-br from-pink-50 to-rose-100 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="bg-pink-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Interactivité Avancée</h3>
                        <p class="text-gray-600 mb-4">
                            Composants Livewire v3 pour une expérience utilisateur dynamique sans rechargement.
                        </p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li>• Mise à jour en temps réel</li>
                            <li>• Interactions fluides</li>
                            <li>• Performance optimisée</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>



        <!-- CTA Section -->
        <section class="py-20 gradient-bg">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                    Prêt à commencer ?
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                        Rejoignez l'ESTM dans sa démarche d'innovation technologique pour une gestion intelligente du stationnement.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" 
                        class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-all duration-300 shadow-xl transform hover:scale-105">
                        Accéder au Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                        class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-all duration-300 shadow-xl transform hover:scale-105">
                        S'inscrire gratuitement
                        </a>
                        <a href="{{ route('login') }}" 
                        class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white hover:text-indigo-600 transition-all duration-300 shadow-xl">
                        Se connecter
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="bg-indigo-600 p-2 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="text-xl font-bold">Parking ESTM</span>
                        </div>
                        <p class="text-gray-400 mb-4">
                            Système de gestion intelligent pour le parking de l'École Supérieure de Technologie de Management.
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Fonctionnalités</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li>Dashboard temps réel</li>
                            <li>Historique des événements</li>
                            <li>API IoT intégrée</li>
                            <li>Interface responsive</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Technologies</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li>Laravel 11</li>
                            <li>Livewire v3</li>
                            <li>Tailwind CSS v3</li>
                            <li>SQLite & ESP32</li>
                        </ul>
                    </div>
                </div
                
                <hr class="border-gray-800 my-8">
                
                <div class="text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} ESTM - École Supérieure de Technologie de Management. Tous droits réservés.</p>
                </div>
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
    </div>
</body>
</html>
