@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="parking-background flex items-center justify-center min-h-screen">
    <div class="surface-panel w-full max-w-md p-8 space-y-6 rounded-lg shadow-xl">
        <div class="text-center">
            <h2 class="text-2xl font-semibold text-gray-900">Connexion</h2>
            <p class="mt-2 text-sm text-gray-600">Connectez-vous pour consulter le tableau de bord.</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="form-label">Adresse e-mail</label>
                <input id="email" type="email" class="form-input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="votre.email@estm.sn">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="form-label">Mot de passe</label>
                <input id="password" type="password" class="form-input" name="password" required autocomplete="current-password" placeholder="••••••••">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="w-4 h-4 text-parking-primary border-gray-300 rounded focus:ring-parking-primary">
                    <label for="remember" class="block ml-2 text-sm text-gray-900">Se souvenir de moi</label>
                </div>
            </div>

            <div>
                <button type="submit" class="btn-primary w-full">
                    Se connecter
                </button>
            </div>
        </form>
        
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="font-medium text-amber-800 hover:text-amber-900">Créer un compte</a>
            </p>
        </div>
    </div>
</div>
@endsection
