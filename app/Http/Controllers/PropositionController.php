<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Models\Demande;
use Illuminate\Http\Request;

class PropositionController extends Controller
{
    public function store(Request $request, Demande $demande)
    {
        $auteur = $request->user();
        abort_if($demande->user_id === $auteur->id, 403, 'Vous ne pouvez pas répondre à votre propre demande.');
        $data = $request->validate([
            'message' => ['required', 'string'],
            'prix' => ['nullable', 'integer', 'min:0'],
        ]);
        $demande->propositions()->create($data + ['user_id' => $auteur->id]);
        Alerte::create([
            'user_id' => $demande->user_id,
            'emetteur_id' => $auteur->id,
            'message' => $auteur->pseudo . ' a répondu à votre demande : ' . $demande->titre,
        ]);
        return back()->with('succes', 'Proposition envoyée au demandeur.');
    }
}