<!-- resources/views/admin/layout.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-800 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Lien vers la liste des utilisateurs -->
            <a href="{{ route('admin.index') }}" class="text-xl font-bold hover:text-gray-300">
                Gestion des utilisateurs
            </a>

            <a href="{{ route('logout') }}" class="text-red-400 hover:text-red-300">
                Déconnexion
            </a>
        </div>
    </nav>

    <main class="container mx-auto py-10">
        @yield('content')
    </main>
</body>
</html>
