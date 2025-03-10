@extends('layouts.app')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ajouter une Attribution</h1>
    </div>

    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-md">
            <form action="{{ route('historique.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Utilisateur :</label>
                    <select name="user_id" class="w-full border p-3 rounded-lg">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Place de Parking :</label>
                    <select name="parking_id" class="w-full border p-3 rounded-lg">
                        @foreach($parkings as $parking)
                            <option value="{{ $parking->id }}">{{ $parking->numero_place }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Date d'Attribution :</label>
                    <input type="datetime-local" name="date_attribution" class="w-full border p-3 rounded-lg" required>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
