<div class="parking-background min-h-screen">
    <!-- Barre de navigation -->
    <nav class="app-nav sticky top-0 z-40">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-3 py-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap items-center gap-x-8 gap-y-2">
                    <a href="/" class="flex items-center gap-3 font-display text-xl text-fg">
                        <img src="/favicon.svg" alt="" class="h-7 w-7 rounded-md">
                        <span>Parking ESTM</span>
                    </a>
                    <div class="flex space-x-1">
                        <a href="/dashboard" class="nav-link nav-link-active">Tableau de bord</a>
                        <a href="/history" class="nav-link nav-link-inactive">Historique</a>
                    </div>
                </div>
                <div class="flex items-center justify-between gap-3 sm:justify-end">
                    @include('partials.theme-toggle')
                    <span class="text-sm text-sand-300">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-secondary">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="eyebrow">Vue d'ensemble</p>
                <h2 class="mt-2 text-3xl sm:text-4xl text-fg">Le parking en direct</h2>
            </div>

            <!-- Chiffres clés -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="surface-panel p-6 rounded-2xl">
                    <h3 class="font-sans text-sm font-medium text-sand-300 mb-3 tracking-normal">Places au total</h3>
                    <p class="font-display text-4xl text-fg">{{ $totalSlots }}</p>
                </div>
                <div class="surface-panel p-6 rounded-2xl">
                    <h3 class="font-sans text-sm font-medium text-sand-300 mb-3 tracking-normal">Places libres</h3>
                    <p class="font-display text-4xl text-parking-free">{{ $availableSlots }}</p>
                </div>
                <div class="surface-panel p-6 rounded-2xl">
                    <h3 class="font-sans text-sm font-medium text-sand-300 mb-3 tracking-normal">Places occupées</h3>
                    <p class="font-display text-4xl text-parking-occupied">{{ $occupiedSlots }}</p>
                </div>
                <div class="surface-panel p-6 rounded-2xl">
                    <h3 class="font-sans text-sm font-medium text-sand-300 mb-3 tracking-normal">Taux d'occupation</h3>
                    <p class="font-display text-4xl text-fg">{{ $occupancyRate }}%</p>
                    <div class="mt-4 h-1 w-full overflow-hidden rounded-full bg-fg/10">
                        <div class="h-full rounded-full bg-azure-400" style="width: {{ $occupancyRate }}%"></div>
                    </div>
                </div>
            </div>

            <!-- État des places de parking -->
            <div class="surface-panel p-6 sm:p-8 rounded-2xl">
                <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between mb-6">
                    <h2 class="text-2xl text-fg">Places du parking</h2>
                    <p class="text-sm text-sand-500">Actualisé toutes les 5 secondes</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @forelse($parkingSlots as $slot)
                    <div class="surface-card p-4 rounded-xl relative border-l-2 {{ $slot->status === 'available' ? 'border-l-parking-free' : 'border-l-parking-occupied' }}">
                        <h3 class="font-sans text-lg font-semibold text-fg mb-1.5 tracking-normal">{{ $slot->slot_code }}</h3>
                        <p class="flex items-center gap-1.5 text-sm font-medium {{ $slot->status === 'available' ? 'text-parking-free' : 'text-parking-occupied' }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $slot->status === 'available' ? 'bg-parking-free' : 'bg-parking-occupied' }}"></span>
                            {{ $slot->status === 'available' ? 'Libre' : 'Occupée' }}
                        </p>
                        @if($slot->is_reserved)
                        <p class="text-xs font-medium text-parking-warning mt-2">
                            Réservée pour : {{ $slot->reserved_for }}
                        </p>
                        @endif
                        <p class="text-xs text-sand-500 mt-2">
                            Dernière détection :
                            {{ $slot->last_detection ? $slot->last_detection->format('d/m/Y à H:i') : 'Aucune donnée' }}
                        </p>
                    </div>
                    @empty
                    <p class="col-span-full py-8 text-center text-sm text-sand-300">
                        Aucune place n’est configurée pour le moment.
                    </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
