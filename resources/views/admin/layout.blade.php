<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="bg-gray-100">


    <!-- Barre de navigation -->
    <nav class="bg-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex space-x-6">

                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Gestion des utilisateurs -->
                <a href="{{ route('admin.index') }}" class="text-lg font-semibold text-gray-700 hover:text-gray-900">
                    Gestion Utilisateurs
                </a>

                <!-- Gestion des places de parking -->
                <a href="{{ route('parking.index') }}" class="text-lg text-gray-700 hover:text-gray-900">
                    Places de Parking
                </a>

                <!-- Liste d'attente -->
                <a href="{{ route('attente.index') }}" class="text-lg text-gray-700 hover:text-gray-900">
                    Liste d'attente
                </a>

                <!-- Historique des attributions -->
                <a href="{{ route('historique.index') }}" class="text-lg text-gray-700 hover:text-gray-900">
                    Historique des attributions
                </a>
            </div>

            <!-- Dropdown Profil / Déconnexion -->
            <div class="relative">
                <button class="text-gray-700 text-lg font-semibold focus:outline-none">
                    t ▼
                </button>
                <div class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg hidden">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="container mx-auto py-10">
        @yield('content')
    </main>

</body>
</html>
