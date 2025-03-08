<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriqueAttribution;
use App\Models\User;
use App\Models\Parking;

class HistoriqueController extends Controller
{
    /**
     * Affiche la liste de l'historique des attributions.
     */
    public function index()
    {
        $historique = HistoriqueAttribution::with(['user', 'parking'])
            ->orderBy('date_attribution', 'desc')
            ->get();

        return view('admin.historique.index', compact('historique'));
    }

    /**
     * Affiche le formulaire pour enregistrer une nouvelle attribution.
     */
    public function create()
    {
        $users = User::all();
        $parkings = Parking::where('est_occupe', false)->get(); // On prend uniquement les places libres

        return view('admin.historique.create', compact('users', 'parkings'));
    }

    /**
     * Enregistre une nouvelle attribution dans l'historique.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'parking_id' => 'required|exists:parking,id',
            'date_attribution' => 'required|date',
        ]);

        // Enregistrer l'attribution
        HistoriqueAttribution::create([
            'user_id' => $request->user_id,
            'parking_id' => $request->parking_id,
            'date_attribution' => $request->date_attribution,
        ]);

        // Marquer la place de parking comme occupée
        $parking = Parking::findOrFail($request->parking_id);
        $parking->est_occupe = true;
        $parking->save();

        return redirect()->route('historique.index')->with('success', 'Attribution enregistrée avec succès.');
    }

    /**
     * Supprime une entrée de l'historique.
     */
    public function destroy($id)
    {
        $historique = HistoriqueAttribution::findOrFail($id);
        $historique->delete();

        return redirect()->route('historique.index')->with('success', 'Entrée supprimée avec succès.');
    }
}
