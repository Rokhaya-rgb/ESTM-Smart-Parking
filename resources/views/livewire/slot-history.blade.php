<div class="parking-background min-h-screen">
    <!-- Barre de navigation -->
    <nav class="bg-slate-900 shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-3 py-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-wrap items-center gap-x-8 gap-y-2">
                    <h1 class="text-xl font-semibold text-white">Parking ESTM</h1>
                    <div class="flex space-x-2">
                        <a href="/dashboard" class="nav-link nav-link-inactive">Tableau de bord</a>
                        <a href="/history" class="nav-link nav-link-active">Historique</a>
                    </div>
                </div>
                <div class="flex items-center justify-between gap-3 sm:justify-end">
                    <span class="text-sm text-slate-200">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
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
            <div class="surface-panel shadow-sm p-6 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">Historique</h2>
                        <p class="mt-1 text-sm text-slate-500">Les changements d’état enregistrés sur les places.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider py-3 px-4">
                                    Place
                                </th>
                                <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider py-3 px-4">
                                    État enregistré
                                </th>
                                <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider py-3 px-4">
                                    Date et heure
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($events as $event)
                                <tr class="hover:bg-slate-50">
                                    <td class="text-sm text-slate-800 py-4 px-4">
                                        {{ $event->parking_slot->slot_code }}
                                        @if($event->parking_slot->is_reserved)
                                            <span class="text-xs text-slate-500 ml-2">Réservée</span>
                                        @endif
                                    </td>
                                    <td class="text-sm py-4 px-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $event->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $event->status === 'available' ? 'Libre' : 'Occupée' }}
                                        </span>
                                    </td>
                                    <td class="text-sm text-slate-600 py-4 px-4">
                                        {{ $event->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-sm text-slate-500">
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
