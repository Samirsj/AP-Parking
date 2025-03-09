<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     */
    public function index()
    {
        if (Auth::user()->can('viewAny', User::class)) {
            $users = User::paginate(10); // Ajout de la pagination
            return view('admin.main', compact('users')); // ✅ Correction ici
        }
        return redirect('/');
    }
    

    /**
     * Affiche le formulaire pour créer un nouvel utilisateur
     */
    public function create()
    {
        return view('admin.createUser');
    }

    /**
     * Stocke un nouvel utilisateur
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
    
        // Création de l'utilisateur
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hachage du mot de passe
            'admin' => $request->has('admin') ? 1 : 0,
        ]);
    
        // Redirection avec un message de succès
        return redirect()->route('admin.index')->with('success', 'Utilisateur ajouté avec succès !');
    }
    
    /**
     * Affiche le formulaire d'édition d'un utilisateur
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    /**
     * Met à jour un utilisateur existant
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
