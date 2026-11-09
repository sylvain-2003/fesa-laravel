@extends('layouts.app')
@section('titre', 'Statistiques')
@section('contenu')
@include('admin.menu')
<div class='grille'>
 @foreach($stats as $libelle => $valeur)
 <div class='carte'>
 <div style='font-size:26px;font-weight:bold;color:#534AB7'>{{ $valeur }}</div>
 <div>{{ $libelle }}</div>
 </div>
 @endforeach
</div>
<div class='carte'>
 <h2>Abonnements par formule</h2>
 @forelse($parPlan as $p) <p>{{ $p->plan->nom }} : {{ $p->total }}</p> @empty <p>Aucun abonnement.</p> @endforelse
</div>
@endsection