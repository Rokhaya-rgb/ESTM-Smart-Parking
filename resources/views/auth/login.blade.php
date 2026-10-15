@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-estm">
    <div class="w-full max-w-md p-8 space-y-6 glass-card">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-indigo-900">Parking ESTM</h2>
            <p class="mt-2 text-sm text-indigo-800">Connectez-vous à votre espace</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="form-label">Adresse Email</label>
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
                Pas encore de compte? 
                <a href="{{ route('register') }}" class="font-medium text-parking-primary hover:text-blue-700">S'inscrire</a>
            </p>
        </div>
    </div>
</div>
@endsection
