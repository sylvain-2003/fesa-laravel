<?php
namespace App\Http\Controllers;
use App\Models\Offre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class RechercheController extends Controller
{
 public function index(Request $request)
 {
 $q = trim((string) $request->query('q'));
 $type = $request->query('type', 'produit');
 $offres = collect();
 $membres = collect();
 if ($q !== '') {
 if ($type === 'fournisseur') {
 $membres = User::where('role', 'membre')->where('actif', true)
 ->where(fn ($w) => $w->where('pseudo', 'like', "%$q%")->orWhere('nom', 'like', "%$q%"))
 ->limit(30)->get();
 } else {
 $offres = Offre::with(['user', 'categorie', 'commentaires.user'])
    ->where('titre', 'like', "%$q%")
    ->when($request->categorie, fn ($w, $id) => $w->where('categorie_id', $id))
    ->latest()->limit(30)->get();
 }
 }
 return view('recherche', compact('q', 'type', 'offres', 'membres'));
 }
 public function image(Request $request)
{
    $request->validate(['image' => ['required', 'image', 'max:3072']]);
    $fichier = $request->file('image');

    $reponse = Http::withHeaders([
        'x-api-key' => config('services.anthropic.key'),
        'anthropic-version' => '2023-06-01',
    ])->timeout(30)->post('https://api.anthropic.com/v1/messages', [
        'model' => 'claude-haiku-5-5',
        'max_tokens' => 50,
        'messages' => [[
            'role' => 'user',
            'content' => [
                ['type' => 'image', 'source' => [
                    'type' => 'base64',
                    'media_type' => $fichier->getMimeType(),
                    'data' => base64_encode(file_get_contents($fichier->getRealPath())),
                ]],
                ['type' => 'text', 'text' => 'Donne uniquement le nom du produit principal visible sur cette image, en français, en 1 à 3 mots, sans phrase.'],
            ],
        ]],
    ]);

    $mot = trim($reponse->json('content.0.text') ?? '');

    if ($mot === '') {
        return redirect()->route('recherche')->with('erreur', 'Impossible de reconnaître le produit sur cette image.');
    }

    return redirect()->route('recherche', ['q' => $mot, 'type' => 'produit']);
}
}