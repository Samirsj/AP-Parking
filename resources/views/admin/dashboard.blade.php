@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord Administrateur</h1>
    </div>

    <!-- Navigation Buttons -->
    <div class="flex justify-center mb-8 space-x-4">
        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-600 bg-white border-b-2 border-blue-500 font-semibold">
            Tableau de Bord
        </a>
        <a href="{{ route('admin.index') }}" class="px-4 py-2 text-gray-600 bg-white border-b-2 border-transparent hover:border-gray-500">
            Gestion Utilisateurs
        </a>
        <a href="{{ route('parking.index') }}" class="px-4 py-2 text-gray-600 bg-white border-b-2 border-transparent hover:border-gray-500">
            Places de Parking
        </a>
        <a href="{{ route('attente.index') }}" class="px-4 py-2 text-gray-600 bg-white border-b-2 border-transparent hover:border-gray-500">
            Liste d'Attente
        </a>
        <a href="{{ route('historique.index') }}" class="px-4 py-2 text-gray-600 bg-white border-b-2 border-transparent hover:border-gray-500">
            Historique
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <h2 class="text-xl font-semibold mb-2">Places Disponibles</h2>
            <p class="text-3xl font-bold text-blue-500">{{ $places_disponibles }}</p>
            <p class="text-gray-600 mt-2">sur {{ $total_places }} places</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <h2 class="text-xl font-semibold mb-2">Utilisateurs Actifs</h2>
            <p class="text-3xl font-bold text-green-500">{{ $users_count }}</p>
            <a href="{{ route('admin.index') }}" class="text-green-600 hover:text-green-800 text-sm mt-2 block">
                Voir tous les utilisateurs →
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <h2 class="text-xl font-semibold mb-2">Liste d'Attente</h2>
            <p class="text-3xl font-bold text-yellow-500">{{ $attente_count }}</p>
            <a href="{{ route('attente.index') }}" class="text-yellow-600 hover:text-yellow-800 text-sm mt-2 block">
                Gérer la liste d'attente →
            </a>
        </div>
    </div>

    <!-- Gestion des Utilisateurs -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Gestion des Utilisateurs</h2>
            <a href="{{ route('admin.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                <i class="fas fa-user-plus mr-2"></i>Ajouter un utilisateur
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Place</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recent_users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $user->role === 'admin' ? 'Administrateur' : 'Utilisateur' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->parking ? 'Place n°' . $user->parking->numero_place : 'Aucune place' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.destroy', $user->id) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-right">
            <a href="{{ route('admin.index') }}" class="text-blue-600 hover:text-blue-800">
                Voir tous les utilisateurs →
            </a>
        </div>
    </div>

    <!-- Actions Rapides -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Actions Rapides</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
            <a href="{{ route('main') }}" 
               class="flex items-center justify-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                <div class="text-center">
                    <i class="fas fa-home text-2xl text-indigo-500 mb-2"></i>
                    <p class="text-gray-700">Page Principale</p>
                </div>
            </a>

            <a href="{{ route('admin.index') }}" 
               class="flex items-center justify-center p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                <div class="text-center">
                    <i class="fas fa-shield-alt text-2xl text-red-500 mb-2"></i>
                    <p class="text-gray-700">Administration</p>
                </div>
            </a>

            <a href="{{ route('parking.create') }}" 
               class="flex items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <div class="text-center">
                    <i class="fas fa-parking text-2xl text-green-500 mb-2"></i>
                    <p class="text-gray-700">Créer une place</p>
                </div>
            </a>

            <a href="{{ route('parking.index') }}" 
               class="flex items-center justify-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                <div class="text-center">
                    <i class="fas fa-list text-2xl text-purple-500 mb-2"></i>
                    <p class="text-gray-700">Gérer les places</p>
                </div>
            </a>

            <a href="{{ route('attente.index') }}" 
               class="flex items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <div class="text-center">
                    <i class="fas fa-clock text-2xl text-blue-500 mb-2"></i>
                    <p class="text-gray-700">Liste d'attente</p>
                </div>
            </a>

            <a href="{{ route('historique.index') }}" 
               class="flex items-center justify-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                <div class="text-center">
                    <i class="fas fa-history text-2xl text-yellow-500 mb-2"></i>
                    <p class="text-gray-700">Voir l'historique</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Dernières Activités -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Dernières Activités</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($activites as $activite)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $activite->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $activite->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $activite->description }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 