@extends('admin.layout')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Historique des Attributions</h1>
    </div>

    <div class="mt-8 flex justify-center">
        <table class="w-full max-w-4xl border border-gray-300 rounded-lg shadow-md bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Utilisateur</th>
                    <th class="px-4 py-2">Numéro de place</th>
                    <th class="px-4 py-2">Date d'attribution</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historique as $record)
                    <tr class="text-center border-b border-gray-200">
                        <td class="px-4 py-2">{{ $record->user->name }}</td>
                        <td class="px-4 py-2">{{ $record->parking->numero_place }}</td>
                        <td class="px-4 py-2">{{ $record->date_attribution }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
