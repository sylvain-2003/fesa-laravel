<?php
namespace App\Http\Controllers;
use App\Models\Alerte;
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Http\Request;
class RendezVousController extends Controller
{
 public function store(Request $request, User $membre)
 {
 $auteur = $request->user();
 abort_if($membre->id === $auteur->id, 422, 'Vous ne pouvez pas prendre rendez-vous avec vous-même.');
 $data = $request->validate(['date_heure' => ['required', 'date', 'after:now']]);
 $rdv = RendezVous::create([
 'demandeur_id' => $auteur->id,
 'fournisseur_id' => $membre->id,
 'date_heure' => $data['date_heure'],
 ]);
 Alerte::create([
 'user_id' => $membre->id,
 'emetteur_id' => $auteur->id,
 'message' => $auteur->pseudo . ' souhaite un rendez-vous le ' . $rdv->date_heure->format('d/m/Y à H:i'),
 ]);
 return back()->with('succes', 'Rendez-vous demandé à ' . $membre->pseudo . '.');
 }
}