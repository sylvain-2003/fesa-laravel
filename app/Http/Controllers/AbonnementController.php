<?php

namespace App\Http\Controllers;

use App\Models\PlanAbonnement;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    public function index(Request $request)
    {
        return view('abonnement.index', [
            'plans' => PlanAbonnement::orderBy('duree_mois')->get(),
            'actif' => $request->user()->abonnementActif(),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate(['plan_id' => ['required', 'exists:plan_abonnements,id']]);
        $plan = PlanAbonnement::findOrFail($request->plan_id);
        $user = $request->user();
        $actif = $user->abonnementActif();
        // Si un abonnement est en cours, le nouveau commence à sa fin
        $debut = $actif ? $actif->date_fin->copy()->addDay() : today();
        $user->abonnements()->create([
            'plan_id' => $plan->id,
            'date_debut' => $debut,
            'date_fin' => $debut->copy()->addMonths($plan->duree_mois),
            'statut' => 'actif',
        ]);
        return redirect()->route('profil.edit')->with('succes', 'Abonnement validé.');
    }
}