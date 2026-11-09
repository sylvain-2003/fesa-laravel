<?php
namespace App\Http\Controllers;
use App\Models\Categorie;
use App\Models\Demande;
use Illuminate\Http\Request;
class DemandeController extends Controller
{
 // CU03 – Voir les demandes (public)
 public function index()
 {
 $demandes = Demande::with(['user', 'categorie', 'propositions.user'])
 ->latest()
 ->simplePaginate(12);
 return view('demandes.index', ['demandes' => $demandes]);
 }
 public function create()
 {
 return view('demandes.create', ['categories' => Categorie::orderBy('nom')->get()]);
 }
 // CU15 – Faire une demande (connexion requise, pas d'abonnement)
 public function store(Request $request)
 {
 $data = $request->validate([
 'categorie_id' => ['required', 'exists:categories,id'],
 'titre' => ['required', 'string', 'max:150'],
 'description' => ['required', 'string'],
 'budget' => ['nullable', 'integer', 'min:0'],
 ]);
 $request->user()->demandes()->create($data);
 return redirect()->route('demandes.index')->with('succes', 'Demande publiée avec succès.');
 }
}