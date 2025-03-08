<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListAttente;
use App\Models\User;

class AttenteController extends Controller
{
    /**
     * Afficher la liste d’attente.
     */
    public function index()
    {
        $attentes = ListAttente::orderBy('position')->get();
        return view('admin.attente.index', compact('attentes'));
    }

    /**
     * Afficher le formulaire pour ajouter un utilisateur à la liste d’attente.
     */
    public function create()
    {
        $users = User::doesntHave('listAttente')->get();
        return view('admin.attente.create', compact('users'));
    }

    /**
     * Ajouter un utilisateur à la liste d’attente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Déterminer la dernière position
        $lastPosition = ListAttente::max('position') ?? 0;

        ListAttente::create([
            'user_id' => $request->user_id,
            'position' => $lastPosition + 1,
        ]);

        return redirect()->route('attente.index')->with('success', 'Utilisateur ajouté à la liste d\'attente.');
    }

    /**
     * Supprimer un utilisateur de la liste d’attente et réorganiser les positions.
     */
    public function destroy($id)
    {
        $attente = ListAttente::findOrFail($id);
        $oldPosition = $attente->position;
        $attente->delete();

        // Réorganiser les positions
        ListAttente::where('position', '>', $oldPosition)->decrement('position');

        return redirect()->route('attente.index')->with('success', 'Utilisateur retiré de la liste d\'attente.');
    }

    /**
     * Modifier la position d’un utilisateur dans la liste d’attente.
     */
    public function updatePosition(Request $request, $id)
    {
        $request->validate([
            'new_position' => 'required|integer|min:1',
        ]);

        $attente = ListAttente::findOrFail($id);
        $newPosition = $request->new_position;
        $oldPosition = $attente->position;

        // Vérifier que la nouvelle position est valide
        $maxPosition = ListAttente::count();
        if ($newPosition > $maxPosition) {
            return redirect()->back()->with('error', 'Position invalide.');
        }

        // Si la position ne change pas, ne rien faire
        if ($oldPosition == $newPosition) {
            return redirect()->back()->with('info', 'La position est déjà correcte.');
        }

        // Réorganiser les positions des autres utilisateurs
        if ($newPosition > $oldPosition) {
            ListAttente::whereBetween('position', [$oldPosition + 1, $newPosition])
                ->decrement('position');
        } else {
            ListAttente::whereBetween('position', [$newPosition, $oldPosition - 1])
                ->increment('position');
        }

        // Mettre à jour la position de l’utilisateur
        $attente->position = $newPosition;
        $attente->save();

        return redirect()->route('attente.index')->with('success', 'Position mise à jour avec succès.');
    }
}
