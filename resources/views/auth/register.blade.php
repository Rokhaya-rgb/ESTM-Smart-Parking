@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="parking-background flex items-center justify-center min-h-screen px-4 py-12">
    <div class="w-full max-w-md">
        <a href="/" class="mb-8 flex items-center justify-center gap-3 text-white">
            <img src="/favicon.svg" alt="" class="w-7 h-7 rounded-md">
            <span class="font-display text-xl">Parking ESTM</span>
        </a>

        <div class="surface-panel p-8 space-y-6 rounded-2xl">
            <div>
                <p class="eyebrow">Nouvel accès</p>
                <h2 class="mt-2 font-display text-3xl text-white">Créer un compte</h2>
                <p class="mt-2 text-sm text-sand-300">Renseignez vos informations pour accéder au tableau de bord.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="form-label">Prénom</label>
                        <input id="first_name" type="text" class="form-input" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="Prénom">
                        @error('first_name')
                            <p class="mt-2 text-sm text-parking-occupied">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_name" class="form-label">Nom</label>
                        <input id="last_name" type="text" class="form-input" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" placeholder="Nom">
                        @error('last_name')
                            <p class="mt-2 text-sm text-parking-occupied">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input id="email" type="email" class="form-input" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="votre.email@estm.sn">
                    @error('email')
                        <p class="mt-2 text-sm text-parking-occupied">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="form-label">Mot de passe</label>
                    <input id="password" type="password" class="form-input" name="password" required autocomplete="new-password" placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-sm text-parking-occupied">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="form-label">Confirmer le mot de passe</label>
                    <input id="password-confirm" type="password" class="form-input" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                </div>

                <button type="submit" class="btn-primary w-full">
                    S'inscrire
                </button>
            </form>

            <p class="pt-2 text-center text-sm text-sand-300">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="font-medium text-azure-300 hover:text-azure-200">Se connecter</a>
            </p>
        </div>
    </div>
</div>
@endsection
