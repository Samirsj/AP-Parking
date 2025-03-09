@extends('/layouts.Layout')

@section('nom')
    <div class="text-center text-2xl font-bold mt-6">
        {{ __('Connecté en tant que admin') }}
    </div>
@endsection

@section('bouton')
    <div class="flex justify-center mt-4">
        <a href="{{ route('admin.create') }}">
            <x-primary-button class="px-4 py-2">
                {{ __('Ajouter un utilisateur') }}
            </x-primary-button>
        </a>
    </div>
@endsection

@section('content')
  <!-- Tableau des utilisateurs -->
  <div class="text-center mb-6 mt-6">
        <h1 class="text-3xl font-bold text-gray-800">Liste des Utilisateurs</h1>
    </div>

    <div class="flex justify-center">
        <div class="w-full max-w-4xl bg-white p-6 rounded-lg shadow-md">
            <table class="w-full border border-gray-300 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-center text-black">Nom</th>
                        <th class="px-4 py-3 text-center text-black">E-mail</th>
                        <th class="px-4 py-3 text-center text-black">Rôle</th>
                        <th class="px-4 py-3 text-center text-black">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="text-center border-b border-gray-200">
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                @if($user->admin)
                                    <span class="text-purple-700 font-bold">Admin</span>
                                @else
                                    <span class="text-gray-700">Utilisateur</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 flex justify-center space-x-6">
                                <a href="{{ route('admin.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900">
                                    Modifier
                                </a>
                                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-4">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">Aucun utilisateur trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- PAGINATION centrée -->
            <div class="mt-4 text-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection