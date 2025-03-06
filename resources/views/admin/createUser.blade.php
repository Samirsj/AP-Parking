@extends('admin.layout')

@section('content')
    <!-- Conteneur principal centré -->
    <div class="flex items-center justify-center min-h-screen">
        <!-- Conteneur du formulaire -->
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold text-center mb-6">Créer un Utilisateur</h1>

            <form action="{{ route('admin.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Nom :</label>
                    <input type="text" name="name" class="w-full border p-3 rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Email :</label>
                    <input type="email" name="email" class="w-full border p-3 rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium">Mot de passe :</label>
                    <input type="password" name="password" class="w-full border p-3 rounded-lg" required>
                </div>

                <div class="mt-4 flex items-center">
                    <input type="checkbox" name="admin" id="admin" class="mr-2">
                    <label for="admin" class="text-gray-700">Attribuer le rôle d'Admin</label>
                </div>

                <div class="mt-6 flex justify-between">
                    <!-- Bouton retour -->
                    <a href="{{ route('admin.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Annuler
                    </a>
                    
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white border border-blue-900 rounded-md hover:bg-blue-600 hover:border-blue-950">
                        Ajouter l'utilisateur
                    </button>


                </div>
            </form>
        </div>
    </div>
@endsection
