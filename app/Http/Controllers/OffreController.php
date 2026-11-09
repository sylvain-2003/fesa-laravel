<?php

namespace App\Http\Controllers;

use App\Models\Alerte;
use App\Models\Categorie;
use App\Models\Offre;
use Illuminate\Http\Request;

class OffreController extends Controller
{
    // CU02 – Voir les offres (public)
    public function index(Request $request)
    {
        $offres = Offre::with(['user', 'categorie', 'commentaires.user'])
            ->when($request->categorie, fn($q, $id) => $q->where('categorie_id', $id))
            ->when($request->type, fn($q, $type) => $q->where('type', $type))
            ->latest()
            ->simplePaginate(12)
            ->withQueryString();
        return view('offres.index', [
            'offres' => $offres,
            'categories' => Categorie::orderBy('nom')->get(),
        ]);
    }
    public function create(Request $request)
    {
        return view('offres.create', [
            'categories' => Categorie::orderBy('nom')->get(),
            'type' => $request->query('type') === 'speciale' ? 'speciale' : 'normale',
        ]);
    }
    // CU09 et CU11 – Publier une offre / une offre spéciale (abonnement requis)
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:normale,speciale'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'titre' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'prix' => ['nullable', 'integer', 'min:0'],
            'prix_promo' => ['required_if:type,speciale', 'nullable', 'integer', 'min:0'],
            'date_fin' => ['nullable', 'date', 'after_or_equal:today'],
            'image' => ['nullable', 'image', 'max:2048'],
            'video' => ['nullable', 'mimetypes:video/mp4,video/webm', 'max:20480'],
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('offres', 'public');
        }
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('videos', 'public');
        }
        $auteur = $request->user();
        $offre = $auteur->offres()->create($data);
        // Alerte pour chaque membre qui suit l'auteur (CU16 et CU17)
        $alertes = $auteur->suiveurs->map(fn($u) => [
            'user_id' => $u->id,
            'emetteur_id' => $auteur->id,
            'message' => $auteur->pseudo . ' a publié : ' . $offre->titre,
            'lu' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ])->all();
        if ($alertes) {
            Alerte::insert($alertes);
        }
        return redirect()->route('offres.index')->with('succes', 'Offre publiée avec succès.');
    }
    public function show(Offre $offre)
    {
        $offre->load(['user', 'categorie', 'commentaires.user']);
        return view('offres.show', ['offre' => $offre]);
    }
}