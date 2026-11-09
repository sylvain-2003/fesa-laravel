<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Abonnement;
use App\Models\Alerte;
use App\Models\Demande;
use App\Models\Information;
use App\Models\Offre;
use App\Models\Proposition;
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', ['informations' => Information::latest()->take(5)->get()]);
    }
    // CU06 – Modifier les informations (affichées à l'accueil)
    public function information(Request $request)
    {
        $data = $request->validate(['contenu' => ['required', 'string', 'max:500']]);
        Information::create(['admin_id' => $request->user()->id, 'contenu' => $data['contenu']]);
        // Alerte pour tous les membres actifs
        $alertes = User::where('role', 'membre')->where('actif', true)->pluck('id')
            ->map(fn($id) => [
                'user_id' => $id,
                'emetteur_id' => $request->user()->id,
                'message' => 'Information : ' . $data['contenu'],
                'lu' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ])->all();
        foreach (array_chunk($alertes, 500) as $lot) {
            Alerte::insert($lot);
        }
        return back()->with('succes', 'Information publiée.');
    }
    // CU07 – Autoriser les accès
    public function acces()
    {
        return view('admin.acces', [
            'membres' => User::where('role', 'membre')->orderBy('pseudo')->simplePaginate(20),
        ]);
    }
    public function basculer(User $user)
    {
        abort_if($user->estAdmin(), 403);
        $user->update(['actif' => ! $user->actif, 'tentatives_echec' => 0, 'bloque_jusqua' => null]);
        return back()->with('succes', 'Compte ' . $user->pseudo . ($user->actif ? ' activé.' : ' désactivé.'));
    }
    // CU08 – Voir les statistiques
    public function statistiques()
    {
        $stats = [
            'Membres' => User::where('role', 'membre')->count(),
            'Comptes actifs' => User::where('role', 'membre')->where('actif', true)->count(),
            'Membres abonnés' => Abonnement::where('statut', 'actif')->whereDate('date_fin', '>=', today())
                ->distinct()->count('user_id'),
            'Offres' => Offre::count(),
            'Offres spéciales' => Offre::where('type', 'speciale')->count(),
            'Demandes' => Demande::count(),
            'Propositions' => Proposition::count(),
            'Rendez-vous' => RendezVous::count(),
            'Ventes (abonnements, F CFA)' => number_format(
                Abonnement::join('plan_abonnements', 'plan_abonnements.id', '=', 'abonnements.plan_id')
                    ->sum('plan_abonnements.prix'),
                0,
                ',',
                ' '
            ),
        ];
        $parPlan = Abonnement::selectRaw('plan_id, count(*) as total')->groupBy('plan_id')->with('plan')->get();
        return view('admin.statistiques', compact('stats', 'parPlan'));
    }
}