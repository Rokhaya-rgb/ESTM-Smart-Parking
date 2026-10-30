<div class="parking-background min-h-screen">
    <!-- Barre de navigation -->
    <nav class="bg-slate-900 shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-3 py-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap items-center gap-x-8 gap-y-2">
                    <h1 class="text-xl font-semibold text-white">Parking ESTM</h1>
                    <div class="flex space-x-2">
                        <a href="/dashboard" class="nav-link nav-link-active">Tableau de bord</a>
                        <a href="/history" class="nav-link nav-link-inactive">Historique</a>
                    </div>
                </div>
                <div class="flex items-center justify-between gap-3 sm:justify-end">
                    <span class="text-sm text-slate-200">Bonjour, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
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

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="surface-panel shadow-sm p-6 rounded-lg">
                    <h2 class="text-base font-medium text-slate-600 mb-2">Places au total</h2>
                    <p class="text-3xl font-semibold text-slate-900">{{ $parkingSlots->count() }}</p>
                </div>
                <div class="surface-panel shadow-sm p-6 rounded-lg">
                    <h2 class="text-base font-medium text-slate-600 mb-2">Places libres</h2>
                    <p class="text-3xl font-semibold text-slate-900">{{ $parkingSlots->where('status', 'available')->count() }}</p>
                </div>
                <div class="surface-panel shadow-sm p-6 rounded-lg">
                    <h2 class="text-base font-medium text-slate-600 mb-2">Places occupées</h2>
                    <p class="text-3xl font-semibold text-slate-900">{{ $parkingSlots->where('status', 'occupied')->count() }}</p>
                </div>
                <div class="surface-panel shadow-sm p-6 rounded-lg">
                    <h2 class="text-base font-medium text-slate-600 mb-2">Taux d'occupation</h2>
                    <p class="text-3xl font-semibold text-slate-900">
                        {{ $parkingSlots->count() > 0
                            ? round(($parkingSlots->where('status', 'occupied')->count() / $parkingSlots->count()) * 100)
                            : 0 }}%
                    </p>
                </div>
            </div>

            <!-- État des places de parking -->
            <div class="surface-panel shadow-sm p-6 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-slate-900">Places du parking</h2>
                    <p class="text-sm text-slate-500">Actualisé toutes les 5 secondes</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @forelse($parkingSlots as $slot)
                    <div class="surface-card border border-gray-200 p-4 rounded-lg relative border-l-4 border-l-amber-300">
                        <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $slot->slot_code }}</h3>
                        <p class="text-sm font-medium {{ $slot->status === 'available' ? 'text-green-700' : 'text-red-700' }}">
                            {{ $slot->status === 'available' ? 'Libre' : 'Occupée' }}
                        </p>
                        @if($slot->is_reserved)
                        <p class="text-xs font-medium text-slate-600 mt-2">
                            Réservée pour : {{ $slot->reserved_for }}
                        </p>
                        @endif
                        <p class="text-xs text-gray-600 mt-1">
                            Dernière détection :
                            {{ $slot->last_detection ? $slot->last_detection->format('d/m/Y à H:i') : 'Aucune donnée' }}
                        </p>
                    </div>
                    @empty
                    <p class="col-span-full py-8 text-center text-sm text-slate-600">
                        Aucune place n’est configurée pour le moment.
                    </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
