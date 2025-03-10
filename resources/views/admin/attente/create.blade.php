@extends('layouts.app')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ajouter à la Liste d'Attente</h1>
    </div>

    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-md">
            <form action="{{ route('attente.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Sélectionner un utilisateur :</label>
                    <select name="user_id" class="w-full border p-3 rounded-lg" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('attente.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
