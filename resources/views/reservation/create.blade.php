@extends('admin.layout')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Faire une Réservation</h1>
    </div>

    <div class="flex justify-center">
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-md">
            <form action="{{ route('reservation.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Utilisateur :</label>
                    <input type="text" value="{{ $user->name }}" class="w-full border p-3 rounded-lg" readonly>
                </div>

                @if($parkingLibre)
                    <input type="hidden" name="parking_id" value="{{ $parkingLibre->id }}">
                    <p class="text-green-600">Une place libre est disponible !</p>
                @else
                    <p class="text-red-600">Aucune place disponible, vous serez ajouté à la liste d'attente.</p>
                @endif

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Réserver
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
