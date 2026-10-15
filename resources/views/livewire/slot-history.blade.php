<div>
    <!-- Barre de navigation -->
    <nav class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-semibold text-gray-900">Parking ESTM</h1>
                    <div class="hidden md:flex space-x-4">
                        <a href="/dashboard" class="nav-link nav-link-inactive">Tableau de bord</a>
                        <a href="/history" class="nav-link nav-link-active">Historique</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-danger">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-6 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-white">Historique des Événements</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="text-left text-xs font-medium text-blue-200 uppercase tracking-wider py-3 px-4">
                                    Place
                                </th>
                                <th class="text-left text-xs font-medium text-blue-200 uppercase tracking-wider py-3 px-4">
                                    État
                                </th>
                                <th class="text-left text-xs font-medium text-blue-200 uppercase tracking-wider py-3 px-4">
                                    Date
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($events as $event)
                                <tr class="hover:bg-white/5">
                                    <td class="text-sm text-white py-4 px-4">
                                        {{ $event->parking_slot->slot_code }}
                                        @if($event->parking_slot->is_reserved)
                                            <span class="text-xs text-yellow-300 ml-2">(Réservée)</span>
                                        @endif
                                    </td>
                                    <td class="text-sm py-4 px-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $event->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $event->status === 'available' ? 'Libre' : 'Occupée' }}
                                        </span>
                                    </td>
                                    <td class="text-sm text-white py-4 px-4">
                                        {{ $event->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                </tr>
                            @endforeach
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
