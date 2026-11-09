@extends('layouts.app')
@section('titre', $membre->pseudo)
@section('contenu')
<div class='carte'>
 @if($membre->photo)
 <img src='{{ asset('storage/' . $membre->photo) }}' alt='' style='width:90px;height:90px;border-radius:50%;object-
 fit:cover'>
 @endif
 <h1>{{ $membre->pseudo }}</h1>
 <p>{{ $membre->nom }} · {{ ucfirst($membre->type_membre) }}</p>
 @if(auth()->id() !== $membre->id)
 <form method='POST' action='{{ route('membres.suivre', $membre) }}'>
 @csrf
 <button class='btn'>{{ $suivi ? 'Se désabonner' : 'S’abonner' }}</button>
 </form>
 @endif
</div>
<div class='carte'>
 <h2>Horaire de service</h2>
 @forelse($horaires as $h)
 <p>{{ $h->jour }} : {{ substr($h->heure_debut, 0, 5) }} – {{ substr($h->heure_fin, 0, 5) }}</p>
 @empty
 <p>Aucun horaire renseigné.</p>
 @endforelse
 @if(auth()->id() !== $membre->id)
 <form method='POST' action='{{ route('rdv.store', $membre) }}'>
 @csrf
 <label>Prendre un rendez-vous</label>
 <input type='datetime-local' name='date_heure' required>
 <button class='btn'>Rendez-vous</button>
 </form>
 @endif
</div>
<h2>Offres de {{ $membre->pseudo }}</h2>
<div class='grille'>
 @foreach($membre->offres as $o) @include('offres._carte', ['offre' => $o]) @endforeach
</div>
@endsection