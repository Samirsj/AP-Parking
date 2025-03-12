@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Gestion des Places de Parking</h1>
                <p class="text-gray-600 mt-2">Gérez toutes les places de parking du système</p>
            </div>
            <div>
                <a href="{{ route('parking.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter une place
                </a>
            </div>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Statut</label>
                    <select id="filter-status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Tous</option>
                        <option value="libre">Libre</option>
                        <option value="occupe">Occupée</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Recherche</label>
                    <input type="text" id="search" placeholder="Numéro de place..." 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Tableau des places -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($places as $place)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $place->numero_place }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($place->user_id)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Occupée par {{ $place->user->name }}
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Libre
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ Str::limit($place->notes, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('parking.edit', $place) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
                                <form action="{{ route('parking.destroy', $place) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette place ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterStatus = document.getElementById('filter-status');
            const search = document.getElementById('search');
            const rows = document.querySelectorAll('tbody tr');

            function filterRows() {
                const statusValue = filterStatus.value.toLowerCase();
                const searchValue = search.value.toLowerCase();

                rows.forEach(row => {
                    const status = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const numero = row.querySelector('td:nth-child(1)').textContent.toLowerCase();

                    const statusMatch = !statusValue || status.includes(statusValue);
                    const searchMatch = !searchValue || numero.includes(searchValue);

                    row.style.display = statusMatch && searchMatch ? '' : 'none';
                });
            }

            filterStatus.addEventListener('change', filterRows);
            search.addEventListener('input', filterRows);
        });
    </script>
    @endpush
@endsection
