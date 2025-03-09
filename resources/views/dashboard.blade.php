@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Tableau de Bord</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- 📌 Votre Place Actuelle -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700">Votre Place Actuelle</h2>
                <p class="text-gray-600 mt-2">
                    @if($attributions->isNotEmpty())
                        <span class="font-bold">Place actuelle :</span> {{ $attributions->first()->parking->numero_place }}
                    @else
                        Aucune place attribuée.
                    @endif
                </p>
            </div>

            <!-- 📌 Historique des Places -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700">Historique des Places</h2>
                <ul class="text-gray-600 mt-2">
                    @forelse($attributions as $attribution)
                        <li>
                            <span class="font-bold">Place N° {{ $attribution->parking->numero_place }}</span> - 
                            Attribuée le {{ $attribution->date_attribution }}
                        </li>
                    @empty
                        <p>Aucune attribution précédente.</p>
                    @endforelse
                </ul>
            </div>

            <!-- 📌 Position dans la file d’attente -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700">Votre Position dans la File d'Attente</h2>
                <p class="text-gray-600 mt-2">
                    @if($position)
                        Vous êtes à la position : <span class="font-bold text-blue-600">{{ $position }}</span>
                    @else
                        Vous n'êtes pas dans la file d'attente.
                    @endif
                </p>
            </div>

            <!-- 📌 Demande de Réservation -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700">Faire une Demande de Réservation</h2>
                <p class="text-gray-600 mt-2">
                    @if($parkingLibre)
                        <!-- 🔵 Bouton bleu si une place est dispo -->
                        <form action="{{ route('reservation.store') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                class="mt-3 px-4 py-2 rounded-md font-bold text-white border-2 border-blue-700 shadow-md 
                                       bg-blue-500 hover:bg-blue-600">
                                Demander une place
                            </button>
                        </form>
                    @else
                        <!-- 🔴 Bouton rouge si AUCUNE place n'est dispo -->
                        <form action="{{ route('attente.store') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                class="mt-3 px-4 py-2 rounded-md font-bold text-white border-2 border-red-700 shadow-md 
                                       bg-red-500 hover:bg-red-600">
                                Ajouter à la File d'Attente
                            </button>
                        </form>
                    @endif
                </p>
            </div>

        </div>
    </div>
@endsection
