@extends('layouts.app')
@section('titre', 'Les offres')
@section('contenu')
<h1>Les offres</h1>
<form method='GET' class='carte'>
 <select name='categorie'>
 <option value=''>Toutes les catégories</option>
 @foreach($categories as $c)
 <option value='{{ $c->id }}' @selected(request('categorie') == $c->id)>{{ $c->nom }}</option>
 @endforeach
 </select>
 <select name='type'>
 <option value=''>Toutes</option>
 <option value='normale' @selected(request('type') === 'normale')>Offres</option>
 <option value='speciale' @selected(request('type') === 'speciale')>Offres spéciales</option>
 </select>
 <button class='btn'>Filtrer</button>
 <a class='btn' href='{{ route('offres.create') }}'>Offre</a>
 <a class='btn' href='{{ route('offres.create', ['type' => 'speciale']) }}'>Offre spéciale</a>
</form>
<div class='grille'>
 @forelse($offres as $o) @include('offres.carte', ['offre' => $o]) @empty <p>Aucune offre pour le moment.</p> @endforelse
</div>
@if($offres->previousPageUrl()) <a class='btn' href='{{ $offres->previousPageUrl() }}'>Précédent</a> @endif
@if($offres->nextPageUrl()) <a class='btn' href='{{ $offres->nextPageUrl() }}'>Suivant</a> @endif
@endsection