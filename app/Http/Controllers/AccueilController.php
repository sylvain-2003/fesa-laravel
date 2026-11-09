<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Demande;
use App\Models\Offre;

class AccueilController extends Controller
{
    public function index()
    {
        $prestation = Categorie::where('nom', 'Prestation de services')->first();

        $offres = Offre::with('categorie')
            ->when($prestation, fn ($q) => $q->where('categorie_id', '!=', $prestation->id))
            ->latest()->take(10)->get();

        $prestations = $prestation
            ? Offre::with('categorie')->where('categorie_id', $prestation->id)->latest()->take(10)->get()
            : collect();

        return view('accueil', [
            'offres' => $offres,
            'demandes' => Demande::with('categorie')->latest()->take(10)->get(),
            'prestations' => $prestations,
            'prestationId' => $prestation?->id,
        ]);
    }
}