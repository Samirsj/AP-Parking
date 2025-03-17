<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.Users.index', compact('users'));
    }

    /**
     * Affiche le formulaire de création d'un utilisateur.
     */
    public function create()
    {
        return view('admin.Users.create');
    }

    /**
     * Enregistre un nouvel utilisateur.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'admin' => ['boolean'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => $request->admin ?? false,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Affiche un utilisateur spécifique.
     */
    public function show(User $user)
    {
        return view('admin.Users.show', compact('user'));
    }

    /**
     * Affiche le formulaire de modification d'un utilisateur.
     */
    public function edit(User $user)
    {
        return view('admin.Users.edit', compact('user'));
    }

    /**
     * Met à jour un utilisateur spécifique.
     */
    public function update(Request $request, User $user)
    {
        // Règles de validation
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'admin' => $request->has('admin') ? 1 : 0,
        ];

        try {
            $user->update($updateData);
            return redirect()->route('admin.index')->with('success', 'Utilisateur mis à jour avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la mise à jour de l\'utilisateur: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour. Veuillez réessayer.'])->withInput();
        }
    }

    /**
     * Supprime un utilisateur spécifique.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.index')
            ->with('success', 'Utilisateur supprimé avec succès.');
    }
} 