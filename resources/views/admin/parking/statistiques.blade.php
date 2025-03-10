@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Statistiques des Places de Parking</h1>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <h3 class="text-lg font-semibold text-gray-700">Total des Places</h3>
            <p class="text-3xl font-bold text-blue-500">{{ $totalPlaces }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <h3 class="text-lg font-semibold text-gray-700">Places Libres</h3>
            <p class="text-3xl font-bold text-green-500">{{ $placesLibres }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <h3 class="text-lg font-semibold text-gray-700">Places Occupées</h3>
            <p class="text-3xl font-bold text-red-500">{{ $placesOccupees }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <h3 class="text-lg font-semibold text-gray-700">En Maintenance</h3>
            <p class="text-3xl font-bold text-yellow-500">{{ $placesMaintenance }}</p>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Répartition par type -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Répartition par Type de Place</h2>
            <div class="space-y-4">
                @foreach($repartitionParType as $type)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-700">{{ ucfirst($type->type_place) }}</span>
                        <span class="text-gray-600">{{ $type->total }} places</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ ($type->total / $totalPlaces) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Répartition par niveau -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Répartition par Niveau</h2>
            <div class="space-y-4">
                @foreach($repartitionParNiveau as $niveau)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-700">{{ $niveau->niveau }}</span>
                        <span class="text-gray-600">{{ $niveau->total }} places</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ ($niveau->total / $totalPlaces) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Bouton retour -->
    <div class="mt-8 text-center">
        <a href="{{ route('parking.index') }}" class="inline-block px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
            Retour à la liste
        </a>
    </div>
</div>
@endsection 