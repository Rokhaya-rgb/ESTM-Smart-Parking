<div class="parking-background min-h-screen">
    <!-- Barre de navigation -->
    <nav class="app-nav sticky top-0 z-40">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-3 py-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap items-center gap-x-8 gap-y-2">
                    <a href="/" class="font-display text-xl text-fg">Parking ESTM</a>
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
            <div class="mb-8">
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
                                    État enregistré
                                </th>
                                <th class="text-left text-xs font-medium text-sand-500 uppercase tracking-wider py-3 px-4">
                                    Date et heure
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-fg/5">
                            @forelse($events as $event)
                                <tr class="hover:bg-fg/5 transition-colors">
                                    <td class="text-sm font-medium text-fg py-4 px-4">
                                        {{ $event->parkingSlot->slot_code }}
                                        @if($event->parkingSlot->is_reserved)
                                            <span class="text-xs text-parking-warning ml-2">Réservée</span>
                                        @endif
                                    </td>
                                    <td class="text-sm py-4 px-4">
                                        <span class="status-badge {{ $event->status_after === 'available' ? 'status-badge-free' : 'status-badge-occupied' }}">
                                            {{ $event->status_after === 'available' ? 'Libre' : 'Occupée' }}
                                        </span>
                                    </td>
                                    <td class="text-sm text-sand-300 py-4 px-4">
                                        {{ $event->detected_at->format('d/m/Y H:i:s') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-sm text-sand-300">
                                        Aucun changement n’a encore été enregistré.
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
