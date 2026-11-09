<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AlerteController extends Controller
{
 public function index(Request $request)
 {
 $user = $request->user();
 $alertes = $user->alertes()->with('emetteur')->latest()->simplePaginate(20);
 // Marque comme lues après récupération de la liste
 $user->alertes()->where('lu', false)->update(['lu' => true]);
 return view('alertes.index', ['alertes' => $alertes]);
 }
}