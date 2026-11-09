<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class HoraireController extends Controller
{
 public const JOURS = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
 public function edit(Request $request)
 {
 return view('horaires.edit', [
 'jours' => self::JOURS,
 'horaires' => $request->user()->horaires->keyBy('jour'),
 ]);
 }
 public function update(Request $request)
 {
 $request->validate([
 'horaires.*.debut' => ['nullable', 'date_format:H:i'],
 'horaires.*.fin' => ['nullable', 'date_format:H:i'],
 ]);
 $user = $request->user();
 $user->horaires()->delete();
 foreach (self::JOURS as $jour) {
 $debut = $request->input("horaires.$jour.debut");
 $fin = $request->input("horaires.$jour.fin");
 if ($debut && $fin && $fin > $debut) {
 $user->horaires()->create(['jour' => $jour, 'heure_debut' => $debut, 'heure_fin' => $fin]);
 }
 }
 return redirect()->route('profil.edit')->with('succes', 'Horaires enregistrés.');
 }
}