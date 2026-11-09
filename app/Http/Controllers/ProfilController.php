<?php
namespace App\Http\Controllers;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProfilController extends Controller
{
 public function edit(Request $request)
 {
 $user = $request->user();
 $rdvs = RendezVous::with(['demandeur', 'fournisseur'])
 ->where(fn ($q) => $q->where('demandeur_id', $user->id)->orWhere('fournisseur_id', $user->id))
 ->where('date_heure', '>=', now())
 ->orderBy('date_heure')
 ->get();
 return view('profil.edit', [
 'user' => $user,
 'actif' => $user->abonnementActif(),
 'rdvs' => $rdvs,
 'offres' => $user->offres()->with('categorie')->latest()->get(),
 'demandes' => $user->demandes()->latest()->get(),
 ]);
 }
 public function photo(Request $request)
 {
 $request->validate(['photo' => ['required', 'image', 'max:2048']]);
 $user = $request->user();
 if ($user->photo) {
 Storage::disk('public')->delete($user->photo);
 }
 $user->update(['photo' => $request->file('photo')->store('profils', 'public')]);
 return back()->with('succes', 'Photo de profil mise à jour.');
 }
}