@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">Modifier l'utilisateur</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-2 text-gray-700">Nom :</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border p-3 rounded-lg" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block mt-2 text-gray-700">Email :</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border p-3 rounded-lg" required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4 flex items-center">
                <input type="checkbox" name="admin" id="admin" class="mr-2" {{ $user->admin ? 'checked' : '' }}>
                <label for="admin" class="text-gray-700">Admin</label>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('admin.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
@endsection 