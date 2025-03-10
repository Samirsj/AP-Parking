@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Modifier la Place de Parking</h1>
            <p class="text-gray-600 mt-2">Modifiez les informations de la place</p>
        </div>

        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <form action="{{ route('parking.update', $parking) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="numero_place" class="block text-gray-700 text-sm font-bold mb-2">
                            Numéro de place
                        </label>
                        <input type="number" name="numero_place" id="numero_place" 
                               value="{{ $parking->numero_place }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               required>
                        @error('numero_place')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">
                            Notes
                        </label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $parking->notes }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <a href="{{ route('parking.index') }}" class="text-blue-500 hover:text-blue-700">
                            <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Retour
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 