<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriqueAttribution;
use App\Models\ListAttente;
use App\Models\Parking;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Afficher le tableau de bord utilisateur.
     */
    public function index()
    {
        $user = auth()->user();

        // Récupérer les informations nécessaires
        $attributions = HistoriqueAttribution::where('user_id', $user->id)
            ->with('parking')
            ->orderBy('date_attribution', 'desc')
            ->get();
        $position = ListAttente::where('user_id', $user->id)->value('position');
        $parkingLibre = Parking::where('est_occupe', false)->exists();

        return view('dashboard', compact('user', 'attributions', 'position', 'parkingLibre'));
    }

    /**
     * Mettre à jour le mot de passe de l'utilisateur.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mot de passe actuel incorrect.');
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
