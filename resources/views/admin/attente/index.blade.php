@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Liste d'Attente</h1>
            <p class="text-gray-600 mt-2">Gérez les demandes de places de parking en attente</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Demandes en attente</h2>
                        <p class="text-sm text-gray-600 mt-1">Liste des utilisateurs en attente d'une place de parking</p>
                    </div>
 
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de demande</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($attentes as $attente)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">N°{{ $attente->position }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $attente->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $attente->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $attente->created_at->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $attente->created_at->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <form method="POST" action="{{ route('attente.updatePosition', $attente->id) }}" class="flex items-center">
                                            @csrf
                                            <input type="number" 
                                                   name="new_position" 
                                                   value="{{ $attente->position }}" 
                                                   class="w-16 px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                   min="1">
                                            <button type="submit" 
                                                    class="ml-2 px-3 py-1 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200 transition-colors duration-200">
                                                Modifier
                                            </button>
                                        </form>
                                        <form action="{{ route('attente.destroy', $attente->id) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('Voulez-vous vraiment retirer cet utilisateur de la liste d\'attente ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-red-100 text-red-600 rounded-md hover:bg-red-200 transition-colors duration-200">
                                                Retirer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($attentes->isEmpty())
                <div class="text-center py-8">
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune demande en attente</h3>
                    <p class="mt-1 text-sm text-gray-500">Commencez par ajouter une nouvelle demande à la liste d'attente.</p>
                </div>
            @endif
        </div>
    </div>
@endsection 