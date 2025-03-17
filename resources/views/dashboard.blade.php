@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- En-tête du tableau de bord -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl font-bold text-gray-800">Tableau de bord</h1>
                @if(Auth::user()->isAdmin())
                    <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-sm font-medium">
                        Connecté en tant qu'administrateur
                    </div>
                @endif
            </div>
            <br>
            <div class="mt-4 bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Bienvenue sur votre espace parking</h2>
                <div class="text-gray-600 space-y-2">
                    <p>Depuis cet espace, vous pouvez :</p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li>Consulter votre place de parking actuelle</li>
                        <li>Voir l'historique de vos attributions</li>
                        <li>Vérifier votre position dans la file d'attente</li>
                        <li>Faire une demande de place ou rejoindre la file d'attente</li>
                    </ul>
                </div>
            </div>
        </div>

        <br>
        <br>

        <!-- Contenu principal -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Place Actuelle -->
            <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-blue-500">
                <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    Place Actuelle
                </h2>
                <div class="mt-2">
                    @if($attributionsActives->isNotEmpty())
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-lg font-bold text-blue-700">Place N° {{ $attributionsActives->first()->parking->numero_place }}</p>
                            <p class="text-sm text-gray-600">Attribuée depuis le {{ \Carbon\Carbon::parse($attributionsActives->first()->date_attribution)->format('d/m/Y') }}</p>
                            
                            <div class="mt-4">
                                <form action="{{ route('reservation.cancel') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler votre réservation ?');">
                                    @csrf
                                    <button type="submit" 
                                        class="w-full px-4 py-2 rounded-md font-medium text-white bg-red-500 hover:bg-red-600 
                                               transition duration-200 ease-in-out flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Annuler la réservation
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-600">Aucune place attribuée</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Historique -->
            <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-green-500">
                <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                    
                    Historique des Places
                </h2>
                <div class="max-h-60 overflow-y-auto">
                    @forelse($attributions as $attribution)
                        <div class="mb-3 p-3 bg-gray-50 rounded-lg {{ $loop->first ? 'border-l-4 border-green-500' : '' }}">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold">Place N° {{ $attribution->parking->numero_place }}</span>
                                <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($attribution->date_attribution)->format('d/m/Y') }}</span>
                            </div>
                            @if($attribution->expiration_at)
                                <div class="mt-1 text-xs text-gray-500">
                                    Annulée le {{ \Carbon\Carbon::parse($attribution->expiration_at)->format('d/m/Y') }}
                                </div>
                            @else
                                <div class="mt-1 text-xs text-green-600">
                                    Réservation active
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-600">Aucun historique disponible</p>
                    @endforelse
                </div>
            </div>

            <!-- File d'attente -->
            <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-yellow-500">
                <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                    </svg>
                    File d'Attente
                </h2>
                <div class="mt-2">
                    @if($position)
                        <div class="bg-yellow-50 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-yellow-700">{{ $position }}</p>
                            <p class="text-sm text-gray-600">Position actuelle</p>
                            <p class="text-xs text-gray-500 mt-2">Vous serez notifié dès qu'une place se libère</p>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-600">Pas dans la file d'attente</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-purple-500">
                <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                  
                    Actions Disponibles
                </h2>
                <div class="mt-2">
                    @if($attributionsActives->isNotEmpty())
                        <div class="bg-blue-50 p-4 rounded-lg text-center">
                            <p class="text-blue-700">Place déjà attribuée</p>
                        </div>
                    @elseif($position)
                        <div class="bg-yellow-50 p-4 rounded-lg text-center">
                            <p class="text-yellow-700">Déjà en file d'attente - Position : {{ $position }}</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                @if($parkingLibre)
                                    <p class="text-green-600">🎉 Places disponibles</p>
                                @else
                                    <p class="text-yellow-600">🚫 Aucune place disponible</p>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 gap-3">
                                @if($parkingLibre)
                                    <form action="{{ route('reservation.store') }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                            class="w-full px-4 py-3 rounded-md font-bold text-white bg-blue-500 hover:bg-blue-600 
                                                   transition duration-200 ease-in-out transform hover:-translate-y-1 flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Demander une place
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('attente.store') }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                            class="w-full px-4 py-3 rounded-md font-bold text-white bg-yellow-500 hover:bg-yellow-600
                                                   transition duration-200 ease-in-out transform hover:-translate-y-1 flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Rejoindre la file d'attente
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
