@extends('admin.layout')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Liste des Réservations</h1>
    </div>

    <div class="mt-8 flex justify-center">
        <table class="w-full max-w-4xl border border-gray-300 rounded-lg shadow-md bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Utilisateur</th>
                    <th class="px-4 py-2">Place de Parking</th>
                    <th class="px-4 py-2">Date de Réservation</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr class="text-center border-b border-gray-200">
                        <td class="px-4 py-2">{{ $reservation->user->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->parking->numero_place }}</td>
                        <td class="px-4 py-2">{{ $reservation->date_reservation }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('reservation.destroy', $reservation->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Annuler</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
