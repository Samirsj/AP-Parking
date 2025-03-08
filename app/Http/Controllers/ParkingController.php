<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parking;

class ParkingController extends Controller
{
    /**
     * Affiche la liste des places de parking.
     */
    public function index()
    {
        $places = Parking::all();
        return view('admin.parking.index', compact('places'));
    }


    /**
     * Affiche le formulaire pour ajouter une nouvelle place.
     */
    public function create()
    {
        return view('admin.parking.places');
    }

    /**
     * Enregistre une nouvelle place de parking.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_place' => 'required|unique:parking|integer',
        ]);

        Parking::create([
            'numero_place' => $request->numero_place,
            'est_occupe' => false,
        ]);

        return redirect()->route('parking.index')->with('success', 'Place ajoutée avec succès.');
    }

    /**
     * Modifie une place existante.
     */
    public function edit(Parking $parking)
    {
        return view('admin.parking.edit', compact('parking'));
    }

    /**
     * Met à jour une place de parking.
     */
    public function update(Request $request, Parking $parking)
    {
        $request->validate([
            'numero_place' => 'required|integer|unique:parking,numero_place,' . $parking->id,
        ]);

        $parking->update([
            'numero_place' => $request->numero_place,
            'est_occupe' => $request->has('est_occupe'),
        ]);

        return redirect()->route('parking.index')->with('success', 'Place mise à jour avec succès.');
    }

    /**
     * Supprime une place de parking.
     */
    public function destroy(Parking $parking)
    {
        $parking->delete();
        return redirect()->route('parking.index')->with('success', 'Place supprimée avec succès.');
    }
}
