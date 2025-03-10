@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Ajouter une Place de Parking</h1>
        </div>

        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <form action="{{ route('parking.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="numero_place" class="block text-gray-700 text-sm font-bold mb-2">
                            Numéro de place
                        </label>
                        <input type="number" name="numero_place" id="numero_place" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                               required>
                        
                        @error('numero_place')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <a href="{{ route('parking.index') }}" class="text-blue-500 hover:text-blue-700">
                            Retour
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Créer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 