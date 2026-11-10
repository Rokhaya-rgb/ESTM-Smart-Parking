<div class="parking-background min-h-screen" wire:poll.1s>
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

    @php
        $levelColor = $occupancyRate >= 85 ? 'bg-parking-occupied' : ($occupancyRate >= 60 ? 'bg-parking-warning' : 'bg-parking-free');
    @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête : titre + état de la maquette -->
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="eyebrow">Vue d'ensemble</p>
                    <h2 class="mt-2 text-3xl sm:text-4xl text-fg">Le parking en direct</h2>
                    <p class="mt-2 text-sm text-sand-300">{{ $totalSlots }} places au total, mises à jour automatiquement.</p>
                </div>
                <div class="live-pill {{ $esp32Online ? 'live-pill-on' : 'live-pill-off' }}">
                    <span class="relative flex h-2.5 w-2.5">
                        @if($esp32Online)
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-parking-free opacity-60"></span>
                        @endif
                        <span class="relative inline-flex h-2.5 w-2.5 rounded-full {{ $esp32Online ? 'bg-parking-free' : 'bg-parking-occupied' }}"></span>
                    </span>
                    Maquette {{ $esp32Online ? 'en ligne' : 'hors ligne' }}
                </div>
            </div>

            <!-- Chiffres clés -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="surface-panel kpi">
                    <div class="kpi-icon text-parking-free bg-parking-free/10">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <h3 class="kpi-label">Places libres</h3>
                    <p class="kpi-value text-parking-free">{{ $availableSlots }}<span class="kpi-sub"> / {{ $totalSlots }}</span></p>
                </div>
                <div class="surface-panel kpi">
                    <div class="kpi-icon text-parking-occupied bg-parking-occupied/10">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18.75V9l1.5-4.5h9L18 9v9.75M6 18.75h12M6 18.75v1.5M18 18.75v1.5M6 12.75h12M8.25 15.75h.008M15.75 15.75h.008"/></svg>
                    </div>
                    <h3 class="kpi-label">Places occupées</h3>
                    <p class="kpi-value text-parking-occupied">{{ $occupiedSlots }}<span class="kpi-sub"> / {{ $totalSlots }}</span></p>
                </div>
                <div class="surface-panel kpi">
                    <div class="kpi-icon text-azure-300 bg-azure-400/15">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                    </div>
                    <h3 class="kpi-label">Taux d'occupation</h3>
                    <p class="kpi-value text-fg">{{ $occupancyRate }}<span class="kpi-sub">%</span></p>
                    <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-fg/10">
                        <div class="h-full rounded-full {{ $levelColor }} transition-all duration-700" style="width: {{ $occupancyRate }}%"></div>
                    </div>
                </div>
                <div class="surface-panel kpi">
                    <div class="kpi-icon text-parking-warning bg-parking-warning/10">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                    </div>
                    <h3 class="kpi-label">Véhicules comptés</h3>
                    <p class="kpi-value text-fg">{{ $vehicleCount ?? '—' }}</p>
                    <p class="mt-1 text-xs text-sand-500">Entrées moins sorties (barrière)</p>
                </div>
            </div>

            <!-- État des places de parking -->
            <div class="surface-panel p-6 sm:p-8 rounded-2xl">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between mb-6">
                    <h2 class="text-2xl text-fg">Places du parking</h2>
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-xs text-sand-300">
                        <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-parking-free"></span>Libre</span>
                        <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-parking-occupied"></span>Occupée</span>
                        <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-parking-warning"></span>Réservée</span>
                        <span class="flex items-center gap-1.5"><span class="h-2 w-2 rounded-full bg-azure-400"></span>Capteur actif</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                    @forelse($parkingSlots as $slot)
                    @php $free = $slot->status === 'available'; @endphp
                    <div class="slot-tile {{ $free ? 'slot-tile-free' : 'slot-tile-occupied' }}">
                        <div class="flex items-start justify-between">
                            <h3 class="font-sans text-xl font-semibold text-fg tracking-normal">{{ $slot->slot_code }}</h3>
                            @if($slot->has_sensor)
                            <span class="mt-1.5 h-2 w-2 rounded-full bg-azure-400" title="Capteur actif"></span>
                            @endif
                        </div>

                        <p class="mt-2 inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $free ? 'bg-parking-free/10 text-parking-free ring-parking-free/25' : 'bg-parking-occupied/10 text-parking-occupied ring-parking-occupied/25' }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $free ? 'bg-parking-free' : 'bg-parking-occupied' }}"></span>
                            {{ $free ? 'Libre' : 'Occupée' }}
                        </p>

                        @if($slot->is_reserved)
                        <p class="mt-2 text-xs font-medium text-parking-warning leading-snug">
                            Réservée : {{ $slot->reserved_for }}
                        </p>
                        @endif

                        <p class="mt-3 text-[11px] text-sand-500" title="{{ $slot->last_detection ? $slot->last_detection->format('d/m/Y à H:i:s') : '' }}">
                            @if($slot->last_detection)
                                {{ $slot->has_sensor ? 'Détecté' : 'Mis à jour' }} {{ $slot->last_detection->diffForHumans() }}
                            @else
                                Aucune donnée
                            @endif
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
