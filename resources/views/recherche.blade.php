@extends('layouts.app')
@section('titre', 'Recherche')
@section('contenu')
<div class='carte'>
 <h1>Recherche</h1>
 <form method='GET' action='{{ route('recherche') }}'>
 <select name='type'>
 <option value='produit' @selected($type === 'produit')>Un produit</option>
 <option value='fournisseur' @selected($type === 'fournisseur')>Un fournisseur</option>
 </select>
 <input name='q' value='{{ $q }}' placeholder='Saisir un nom'>
 <button class='btn'>Rechercher</button>
 </form>
</div>
@if($q !== '' && $offres->isEmpty() && $membres->isEmpty())
 <p>No results</p>
@endif
<div class='grille'>
 @foreach($offres as $o) @include('offres.carte', ['offre' => $o]) @endforeach
 @foreach($membres as $m)
 <div class='carte'>
 <h3><a href='{{ route('membres.show', $m) }}'>{{ $m->pseudo }}</a></h3>
 <p>{{ $m->nom }}</p>
 </div>
 @endforeach
</div>
@endsection