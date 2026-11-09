@extends('layouts.app')
@section('titre', 'Les demandes')
@section('contenu')
<h1>Les demandes</h1>
<p><a class='btn' href='{{ route('demandes.create') }}'>Faire une demande</a></p>
@forelse($demandes as $d)
 <div class='carte'>
 <span class='badge'>{{ $d->categorie->nom }}</span>
 <h3>{{ $d->titre }}</h3>
 <p>{{ $d->description }}</p>
 @if($d->budget)<p>Budget : <strong>{{ number_format($d->budget, 0, ',', ' ') }} F</strong></p>@endif
 <p>Par {{ $d->user->pseudo }} · {{ $d->propositions->count() }} proposition(s)</p>
 @auth
 @if(auth()->id() === $d->user_id)
 @foreach($d->propositions as $p)
 <div style='border-top:1px solid #eee;padding-top:8px'>
 <strong><a href='{{ route('membres.show', $p->user) }}'>{{ $p->user->pseudo }}</a></strong>
 {{ $p->prix ? ' – ' . number_format($p->prix, 0, ',', ' ') . ' F' : '' }}<br>{{ $p->message }}
 </div>
 @endforeach
 @else
 <details>
 <summary>Proposition</summary>
 <form method='POST' action='{{ route('propositions.store', $d) }}'>
 @csrf
 <textarea name='message' rows='3' placeholder='Votre proposition' required></textarea>
 <input type='number' name='prix' placeholder='Prix proposé (F CFA)'>
 <button class='btn'>Valider</button>
 </form>
 </details>
 @endif
 @endauth
 </div>
@empty
 <p>Aucune demande pour le moment.</p>
@endforelse
@if($demandes->previousPageUrl()) <a class='btn' href='{{ $demandes->previousPageUrl() }}'>Précédent</a> @endif
@if($demandes->nextPageUrl()) <a class='btn' href='{{ $demandes->nextPageUrl() }}'>Suivant</a> @endif
@endsection