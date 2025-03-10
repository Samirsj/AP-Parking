@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Places de Parking</h1>
        <p class="text-gray-600 mt-2">Bienvenue dans votre espace de gestion</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- État de votre place -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <h2 class="text-xl font-semibold mb-4">Votre Place Actuelle</h2>
            @if(Auth::user()->parking)
                <div class="text-center">
                    <p class="text-3xl font-bold text-blue-500">Place N°{{ Auth::user()->parking->numero_place }}</p>
                    <p class="text-gray-600 mt-2">Attribuée depuis le {{ Auth::user()->parking->date_attribution }}</p>
                </div>
            @else
                <div class="text-center">
                    <p class="text-gray-600">Vous n'avez pas de place attribuée</p>
                    <a href="{{ route('attente.create') }}" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Rejoindre la liste d'attente
                    </a>
                </div>
            @endif
        </div>

        <!-- Position dans la file d'attente -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <h2 class="text-xl font-semibold mb-4">File d'Attente</h2>
            @if($position = Auth::user()->positionAttente())
                <div class="text-center">
                    <p class="text-3xl font-bold text-yellow-500">Position {{ $position }}</p>
                    <p class="text-gray-600 mt-2">dans la file d'attente</p>
                </div>
            @else
                <div class="text-center">
                    <p class="text-gray-600">Vous n'êtes pas dans la file d'attente</p>
                </div>
            @endif
        </div>

        <!-- Actions disponibles -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <h2 class="text-xl font-semibold mb-4">Actions</h2>
            <div class="space-y-4">
                @if(Auth::user()->parking)
                    <form action="{{ route('parking.liberer') }}" method="POST" class="text-center">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                                onclick="return confirm('Êtes-vous sûr de vouloir libérer votre place ?');">
                            Libérer ma place
                        </button>
                    </form>
                @elseif(!Auth::user()->positionAttente())
                    <a href="{{ route('attente.create') }}" class="block w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 text-center">
                        Demander une place
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Historique -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Votre Historique</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Place</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($historique as $record)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $record->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Place N°{{ $record->parking->numero_place }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $record->action }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 