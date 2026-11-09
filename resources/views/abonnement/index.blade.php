@extends('layouts.app')
@section('titre', 'Abonnement')
@section('contenu')
<div class='carte'>
 <h1>Faire un abonnement</h1>
 @if($actif)
 <p class='ok'>Abonnement actif jusqu'au {{ $actif->date_fin->format('d/m/Y') }}.</p>
 @else
 <p>Un abonnement est nécessaire pour publier une offre, faire une offre spéciale, faire une proposition et mettre 
 votre horaire de service.</p>
 @endif
 <form method='POST' action='{{ route('abonnement.store') }}'>
 @csrf
 @foreach($plans as $p)
 <label style='display:block;margin-bottom:8px'>
 <input type='radio' name='plan_id' value='{{ $p->id }}' style='width:auto' required>
 {{ $p->nom }} – {{ number_format($p->prix, 0, ',', ' ') }} F
 </label>
 @endforeach
 <button class='btn'>Valider</button>
 </form>
</div>
@endsection