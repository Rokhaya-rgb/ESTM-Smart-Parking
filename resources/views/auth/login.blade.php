@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="parking-background relative flex items-center justify-center min-h-screen px-4 py-12">
    <div class="absolute right-4 top-4">
        @include('partials.theme-toggle')
    </div>
    <div class="w-full max-w-md">
        <a href="/" class="mb-8 flex items-center justify-center gap-3 text-fg">
            <img src="/favicon.svg" alt="" class="w-7 h-7 rounded-md">
            <span class="font-display text-xl">Parking ESTM</span>
        </a>

        <div class="surface-panel animate-fade-up p-8 space-y-6 rounded-2xl">
            <div>
                <div class="auth-badge">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                </div>
                <p class="eyebrow">Espace membre</p>
                <h2 class="mt-2 font-display text-3xl text-fg">Connexion</h2>
                <p class="mt-2 text-sm text-sand-300">Connectez-vous pour consulter le tableau de bord.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input id="email" type="email" class="form-input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="votre.email@estm.sn">
                    @error('email')
                        <p class="mt-2 text-sm text-parking-occupied">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="form-label">Mot de passe</label>
                    <input id="password" type="password" class="form-input" name="password" required autocomplete="current-password" placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-sm text-parking-occupied">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="w-4 h-4 rounded border-fg/25 bg-fg/5 text-azure-400 focus:ring-azure-400 focus:ring-offset-0">
                    <label for="remember" class="block ml-2 text-sm text-sand-300">Se souvenir de moi</label>
                </div>

                <button type="submit" class="btn-primary w-full">
                    Se connecter
                </button>
            </form>

            <p class="pt-2 text-center text-sm text-sand-300">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="font-medium text-azure-300 hover:text-azure-200">Créer un compte</a>
            </p>
        </div>
    </div>
</div>
@endsection
