<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriqueAttribution;
use App\Models\ListAttente;
use App\Models\Parking;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
