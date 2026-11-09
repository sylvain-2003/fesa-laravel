@extends('layouts.app')
@section('titre', 'Alertes')
@section('contenu')
<h1>Alertes</h1>
@forelse($alertes as $a)
 <div class='carte'>
 @if(! $a->lu)<span class='badge'>Nouveau</span>@endif
 {{ $a->message }}
 <small style='color:#888'> · {{ $a->created_at->diffForHumans() }}</small>
 </div>
@empty
 <p>Aucune alerte pour le moment.</p>
@endforelse
@if($alertes->previousPageUrl()) <a class='btn' href='{{ $alertes->previousPageUrl() }}'>Précédent</a> @endif
@if($alertes->nextPageUrl()) <a class='btn' href='{{ $alertes->nextPageUrl() }}'>Suivant</a> @endif
@endsection