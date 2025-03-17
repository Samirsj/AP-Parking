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

        // Récupérer les attributions actives (pour la Place Actuelle)
        $attributionsActives = HistoriqueAttribution::where('user_id', $user->id)
            ->whereNull('expiration_at')
            ->with('parking')
            ->orderBy('date_attribution', 'desc')
            ->get();
            
        // Récupérer toutes les attributions pour l'historique
        $attributions = HistoriqueAttribution::where('user_id', $user->id)
            ->with('parking')
            ->orderBy('date_attribution', 'desc')
            ->get();
            
        $position = ListAttente::where('user_id', $user->id)->value('position');
        $parkingLibre = Parking::whereNull('user_id')->exists();

        return view('dashboard', compact('user', 'attributions', 'attributionsActives', 'position', 'parkingLibre'));
    }

}
