@extends('admin.layout')

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">Modifier l'utilisateur</h1>

        <form action="{{ route('admin.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="block mb-2 text-gray-700">Nom :</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full border p-3 rounded-lg" required>

            <label class="block mt-4 text-gray-700">Email :</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full border p-3 rounded-lg" required>

            <div class="mt-4 flex items-center">
                <input type="checkbox" name="admin" id="admin" class="mr-2" {{ $user->admin ? 'checked' : '' }}>
                <label for="admin" class="text-gray-700">Admin</label>
            </div>

            <button type="submit" class="w-full mt-6 bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-lg">
                Mettre à jour
            </button>
        </form>
    </div>
@endsection
