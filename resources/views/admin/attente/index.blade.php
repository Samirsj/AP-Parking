@extends('admin.layout')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Liste d'Attente</h1>
    </div>

    <div class="mt-8 flex justify-center">
        <table class="w-full max-w-4xl border border-gray-300 rounded-lg shadow-md bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Nom</th>
                    <th class="px-4 py-2">Position</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attentes as $attente)
                    <tr class="text-center border-b border-gray-200">
                        <td class="px-4 py-2">
                            {{ $attente->user ? $attente->user->name : 'Utilisateur introuvable' }}
                        </td>
                        <td class="px-4 py-2">
                            <form action="{{ route('attente.updatePosition', $attente->id) }}" method="POST">
                                @csrf
                                <input type="number" name="new_position" value="{{ $attente->position }}" 
                                    min="1" class="border p-2 w-16 text-center">
                                <button type="submit" class="ml-2 px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    Modifier
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-2">
                            <form action="{{ route('attente.destroy', $attente->id) }}" method="POST"
                                onsubmit="return confirm('Supprimer cet utilisateur de la liste d\'attente ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
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
