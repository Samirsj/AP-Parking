<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListAttente;
use App\Models\User;
use App\Models\Parking;
use App\Models\HistoriqueAttribution;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;



class AttenteController extends Controller
{
    /**
     * Afficher la liste d'attente.
     */
    public function index()
    {
        $attentes = ListAttente::with('user')->orderBy('position')->get();
        return view('admin.attente.index', compact('attentes'));
    }
    

    /**
     * Afficher le formulaire pour ajouter un utilisateur à la liste d'attente.
     */
    public function create()
    {
        $users = User::whereNotIn('id', ListAttente::pluck('user_id'))->get();
        
        if ($users->isEmpty()) {
            return redirect()->route('attente.index')->with('error', 'Tous les utilisateurs sont déjà en liste d\'attente.');
        }

        return view('admin.attente.create', compact('users'));
    }


        /**
         * Ajouter un utilisateur à la liste d'attente si aucune place n'est dispo.
         */
        public function store(Request $request)
        {
            $user = Auth::user(); 
    
            // Vérifier si l'utilisateur est déjà dans la liste d'attente
            if (ListAttente::where('user_id', $user->id)->exists()) {
                return redirect()->route('dashboard')->with('info', 'Vous êtes déjà dans la file d\'attente.');
            }
    
            // Déterminer la dernière position dans la file d'attente
            $lastPosition = ListAttente::max('position') ?? 0;
    
            // Ajouter l'utilisateur à la liste d'attente
            ListAttente::create([
                'user_id' => $user->id,
                'position' => $lastPosition + 1,
            ]);
    
            return redirect()->route('dashboard')->with('success', 'Vous avez été ajouté à la file d\'attente.');
        }
    
    

    /**
     * Supprimer un utilisateur de la liste d'attente et réorganiser les positions.
     */
    public function destroy($id)
    {
        $attente = ListAttente::findOrFail($id);
        $oldPosition = $attente->position;
        $attente->delete();

        ListAttente::where('position', '>', $oldPosition)->decrement('position');

        return redirect()->route('attente.index')->with('success', 'Utilisateur retiré de la liste d\'attente.');
    }

    /**
     * Modifier la position d'un utilisateur dans la liste d'attente.
     */
    public function updatePosition(Request $request, $id)
    {
        $request->validate([
            'new_position' => 'required|integer|min:1',
        ]);

        $attente = ListAttente::findOrFail($id);
        $newPosition = (int) $request->new_position;
        $oldPosition = $attente->position;

        $maxPosition = ListAttente::count();
        if ($newPosition > $maxPosition) {
            return redirect()->back()->with('error', 'Position invalide.');
        }

        DB::transaction(function () use ($attente, $newPosition, $oldPosition) {
            // Utiliser une position temporaire très grande pour éviter les conflits
            $tempPosition = ListAttente::max('position') + 1000;
            
            // Déplacer d'abord l'élément à une position temporaire
            $attente->update(['position' => $tempPosition]);

            if ($newPosition > $oldPosition) {
                // Si on déplace vers le bas, on décrémente les positions entre l'ancienne et la nouvelle
                ListAttente::whereBetween('position', [$oldPosition + 1, $newPosition])
                    ->decrement('position');
            } else {
                // Si on déplace vers le haut, on incrémente les positions entre la nouvelle et l'ancienne
                ListAttente::whereBetween('position', [$newPosition, $oldPosition - 1])
                    ->increment('position');
            }

            // Finalement, mettre à jour la position finale
            $attente->update(['position' => $newPosition]);
        });

        return redirect()->route('attente.index')->with('success', 'Position mise à jour avec succès.');
    }

    /**
     * Attribue une place au premier utilisateur de la liste d'attente
     */
    public function attribuerPlacePremier()
    {
        try {
            DB::beginTransaction();

            // Vérifier s'il y a des places libres
            $placeLibre = Parking::whereNull('user_id')->first();
            if (!$placeLibre) {
                return back()->with('error', 'Aucune place libre disponible.');
            }

            // Récupérer le premier utilisateur de la liste d'attente
            $premierAttente = ListAttente::orderBy('position')->first();
            if (!$premierAttente) {
                return back()->with('error', 'Aucun utilisateur en attente.');
            }

            // Récupérer l'utilisateur
            $user = User::findOrFail($premierAttente->user_id);

            // Mettre à jour la place de parking
            $placeLibre->update([
                'user_id' => $user->id,
                'est_occupe' => true
            ]);

            // Créer une entrée dans l'historique des attributions
            HistoriqueAttribution::create([
                'user_id' => $user->id,
                'parking_id' => $placeLibre->id,
                'date_attribution' => now()
            ]);

            // Supprimer l'utilisateur de la liste d'attente
            $premierAttente->delete();

            // Réorganiser les positions de la liste d'attente
            $this->reorganiserPositions();

            DB::commit();

            return back()->with('success', 'Place attribuée avec succès à ' . $user->name);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de l\'attribution de la place.');
        }
    }

    /**
     * Réorganise les positions de la liste d'attente
     */
    private function reorganiserPositions()
    {
        $attentes = ListAttente::orderBy('position')->get();
        foreach ($attentes as $index => $attente) {
            $attente->update(['position' => $index + 1]);
        }
    }
}
