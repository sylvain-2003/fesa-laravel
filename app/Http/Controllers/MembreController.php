<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MembreController extends Controller
{
    public function show(Request $request, User $membre)
    {
        $membre->load(['offres.user', 'offres.categorie', 'offres.commentaires.user', 'horaires']);
        $horaires = $membre->horaires
            ->sortBy(fn($h) => array_search($h->jour, HoraireController::JOURS))
            ->values();
        return view('membres.show', [
            'membre' => $membre,
            'horaires' => $horaires,
            'suivi' => $request->user()->suit($membre),
        ]);
    }
    public function suivre(Request $request, User $membre)
    {
        abort_if($membre->id === $request->user()->id, 422, 'Vous ne pouvez pas vous suivre vous-même.');
        $request->user()->suivis()->toggle($membre->id);
        return back()->with('succes', 'Votre abonnement à ce membre a été mis à jour.');
    }
}