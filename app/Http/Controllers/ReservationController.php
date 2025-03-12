<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriqueAttribution;
use App\Models\ListAttente;
use App\Models\Parking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Gérer la demande de réservation
     */

    public function store(Request $request)
    {
        $user = Auth::user();

        // Vérifier s'il y a une place disponible
        $parkingLibre = Parking::whereNull('user_id')->first();

        if ($parkingLibre) {
            // Attribuer la place
            $parkingLibre->marquerOccupee($user->id);

            // Enregistrer l'attribution dans l'historique
            HistoriqueAttribution::create([
                'user_id' => $user->id,
                'parking_id' => $parkingLibre->id,
                'date_attribution' => now(),
            ]);

            return redirect()->route('dashboard')->with('success', 'Place attribuée avec succès.');
        } else {
            // Ajouter à la file d'attente
            $lastPosition = ListAttente::max('position') ?? 0;

            ListAttente::create([
                'user_id' => $user->id,
                'position' => $lastPosition + 1,
            ]);

            return redirect()->route('dashboard')->with('info', 'Aucune place disponible. Vous avez été ajouté à la file d\'attente.');
        }
    }
}




