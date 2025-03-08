@extends('admin.layout')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Places de Parking</h1>
    </div>

    <div class="flex justify-center">
        <a href="{{ route('parking.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Ajouter une place
        </a>
    </div>

    <div class="mt-8 flex justify-center">
        <table class="w-full max-w-4xl border border-gray-300 rounded-lg shadow-md bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Numéro</th>
                    <th class="px-4 py-2">Statut</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($places as $place)
                    <tr class="text-center border-b border-gray-200">
                        <td class="px-4 py-2">{{ $place->numero_place }}</td>
                        <td class="px-4 py-2">
                            @if($place->est_occupe)
                                <span class="text-red-600 font-bold">Occupée</span>
                            @else
                                <span class="text-green-600 font-bold">Libre</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 flex justify-center space-x-6"> <!-- Augmenté à space-x-6 pour plus d'espace -->
                            <a href="{{ route('parking.edit', $place->id) }}" class="text-blue-600 hover:text-blue-900">
                                Modifier
                            </a>
                            <form action="{{ route('parking.destroy', $place->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette place ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 ml-6"> <!-- Ajout de ml-6 pour espacer -->
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
