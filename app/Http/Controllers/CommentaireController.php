<?php
namespace App\Http\Controllers;
use App\Models\Alerte;
use App\Models\Offre;
use Illuminate\Http\Request;
class CommentaireController extends Controller
{
 public function store(Request $request, Offre $offre)
 {
 $data = $request->validate(['contenu' => ['required', 'string', 'max:500']]);
 $auteur = $request->user();
 $offre->commentaires()->create($data + ['user_id' => $auteur->id]);
 if ($offre->user_id !== $auteur->id) {
 Alerte::create([
 'user_id' => $offre->user_id,
 'emetteur_id' => $auteur->id,
 'message' => $auteur->pseudo . ' a commenté votre offre : ' . $offre->titre,
 ]);
 }
 return back()->with('succes', 'Commentaire enregistré.');
 }
}