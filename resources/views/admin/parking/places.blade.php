@extends('layouts.app')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Ajouter une Place de Parking</h1>
    </div>

    <div class="flex items-center justify-center">
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow">

            <form action="{{ route('parking.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Numéro de place :</label>
                    <input type="number" name="numero_place" class="w-full border p-3 rounded-lg" required>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('parking.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Annuler
                    </a>

                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Ajouter la place
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
