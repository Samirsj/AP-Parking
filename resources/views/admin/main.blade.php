<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Connecté en tant que admin') }}
        </h2>
        <br>
        <a href="/admin/create">
                <x-primary-button class="mr-2">
                    {{ __('Ajouter des utilisateurs') }}
                </x-primary-button>
            </a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <table class="min-w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-center text-black">Nom</th>
                                    <th class="px-4 py-2 text-center text-black">Prenom</th>
                                    <th class="px-4 py-2 text-center text-black">e-mail</th>
                                    <th class="px-4 py-2 text-center text-black">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="text-center">
                                    <td class="px-4 py-2 text-left text-black">{{ $user->last_name }}</td>
                                    <td class="px-4 py-2 text-left text-black">{{ $user->first_name }}</td>
                                    <td class="px-4 py-2 text-left text-black">{{ $user->email }}</td>
                                </tr>
                                @endforeach
                               
                </div>
            </div>
        </div>
    </div>
</x-app-layout>