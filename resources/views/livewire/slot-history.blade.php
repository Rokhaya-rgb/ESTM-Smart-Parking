<div class="parking-background min-h-screen" wire:poll.3s>
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
                        <a href="/dashboard" class="nav-link nav-link-inactive">Tableau de bord</a>
                        <a href="/history" class="nav-link nav-link-active">Historique</a>
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
            <div class="mb-8 on-photo">
                <p class="eyebrow">Journal</p>
                <h2 class="mt-2 text-3xl sm:text-4xl text-fg">Historique</h2>
                <p class="mt-2 text-sm text-sand-300">Les changements d’état enregistrés sur les places.</p>
            </div>

            <div class="surface-panel p-4 sm:p-8 rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-fg/10">
                        <thead>
                            <tr>
                                <th class="text-left text-xs font-medium text-sand-500 uppercase tracking-wider py-3 px-4">
                                    Place
                                </th>
                                <th class="text-left text-xs font-medium text-sand-500 uppercase tracking-wider py-3 px-4">
                                    Changement
                                </th>
                                <th class="text-left text-xs font-medium text-sand-500 uppercase tracking-wider py-3 px-4">
                                    Source
                                </th>
                                <th class="text-left text-xs font-medium text-sand-500 uppercase tracking-wider py-3 px-4">
                                    Date et heure
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-fg/5">
                            @forelse($events as $event)
                                @php
                                    $before = $event->status_before === 'available';
                                    $after = $event->status_after === 'available';
                                @endphp
                                <tr class="hover:bg-fg/5 transition-colors">
                                    <td class="py-4 px-4">
                                        <span class="slot-chip">{{ $event->parkingSlot->slot_code }}</span>
                                        @if($event->parkingSlot->is_reserved)
                                            <span class="ml-2 text-xs text-parking-warning">Réservée</span>
                                        @endif
                                    </td>
                                    <td class="text-sm py-4 px-4">
                                        <div class="flex items-center gap-2">
                                            <span class="status-badge {{ $before ? 'status-badge-free' : 'status-badge-occupied' }} opacity-70">{{ $before ? 'Libre' : 'Occupée' }}</span>
                                            <svg class="h-4 w-4 text-sand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                                            <span class="status-badge {{ $after ? 'status-badge-free' : 'status-badge-occupied' }}">{{ $after ? 'Libre' : 'Occupée' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-sm text-sand-300 py-4 px-4">
                                        {{ in_array($event->source, ['mqtt', 'simulation']) ? 'Capteur (maquette)' : ucfirst($event->source) }}
                                    </td>
                                    <td class="text-sm text-sand-300 py-4 px-4">
                                        <span class="text-fg">{{ $event->detected_at->format('d/m/Y H:i:s') }}</span>
                                        <span class="ml-2 text-xs text-sand-500">{{ $event->detected_at->diffForHumans() }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-14 text-center">
                                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-azure-400/15 text-azure-300">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z"/></svg>
                                        </div>
                                        <p class="text-sm text-sand-300">Aucun changement n’a encore été enregistré.</p>
                                        <p class="mt-1 text-xs text-sand-500">Ils apparaîtront ici dès qu’un véhicule se gare ou quitte une place.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
