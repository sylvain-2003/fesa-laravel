@extends('layouts.app')
@section('titre', 'Accueil')
@section('contenu')

@isset($information)
  @if($information)<div class='ok'><strong>Information :</strong> {{ $information->contenu }}</div>@endif
@endisset

<section class='hero'>
  <div class='hero-haut'>
    <h1>Bienvenue sur FeSA</h1>
    <a class='panier' href='{{ route('offres.index') }}' title='Faire un achat'>🛒</a>
  </div>
  <div class='actions'>
    <a class='action' href='{{ route('offres.index') }}'><b>★</b> faire un achat</a>
    <a class='action' href='{{ route('demandes.create', ['categorie' => $prestationId]) }}'><b>★</b> demander une prestation</a>
  </div>
  <p class='slogan'>Trouver facilement votre produit en un clic</p>
</section>

<div class='titre-rangee'><span>Offres</span><a href='{{ route('offres.index') }}'>Voir tout</a></div>
<div class='rangee'>
  @forelse($offres as $o)
    @include('partials.tuile', ['offre' => $o])
  @empty
    <p class='vide'>Aucune offre pour le moment.</p>
  @endforelse
</div>

<div class='titre-rangee'><span>Demandes</span><a href='{{ route('demandes.index') }}'>Voir tout</a></div>
<div class='rangee'>
  @forelse($demandes as $d)
    <a class='tuile' href='{{ route('demandes.index') }}'>
      <span>{{ Str::limit($d->titre, 40) }}</span>
    </a>
  @empty
    <p class='vide'>Aucune demande pour le moment.</p>
  @endforelse
</div>

<div class='titre-rangee'><span>Les prestations</span><a href='{{ route('offres.index', ['categorie' => $prestationId]) }}'>Voir tout</a></div>
<div class='rangee'>
  @forelse($prestations as $p)
    @include('partials.tuile', ['offre' => $p])
  @empty
    <p class='vide'>Aucune prestation pour le moment.</p>
  @endforelse
</div>
@endsection