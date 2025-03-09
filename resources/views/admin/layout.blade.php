<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Barre de navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center text-center">
            <!-- Menu principal centré -->
            <div class="flex space-x-8 items-center justify-center w-full">
                
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Liens de navigation -->
                <a href="{{ route('admin.index') }}" class="text-lg font-semibold text-gray-700 hover:text-gray-900">
                    Gestion Utilisateurs
                </a>

                <a href="{{ route('parking.index') }}" class="text-lg text-gray-700 hover:text-gray-900">
                    Places de Parking
                </a>

                <a href="{{ route('attente.index') }}" class="text-lg text-gray-700 hover:text-gray-900">
                    Liste d'attente
                </a>

                <a href="{{ route('historique.index') }}" class="text-lg text-gray-700 hover:text-gray-900">
                    Historique des attributions
                </a>
            </div>

            <!-- Profil & Déconnexion -->
            <div class="relative">
                <button id="profileMenuButton" class="flex items-center text-gray-700 focus:outline-none">
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="ml-2 h-4 w-4 fill-current" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
                <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-md">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        {{ __('Profil') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                            {{ __('Déconnexion') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal centré -->
    <main class="flex-grow flex items-center justify-center py-10">
        <div class="container mx-auto text-center">
            @yield('content')
        </div>
    </main>

</body>
</html>
