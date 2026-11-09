@extends('layouts.app')
@section('titre', 'Mon espace')
@section('contenu')
<div class='carte'>
 @if($user->photo)
 <img src='{{ asset('storage/' . $user->photo) }}' alt='' style='width:90px;height:90px;border-radius:50%;object-fi
 t:cover'>
 @endif
 <h1>{{ $user->pseudo }}</h1>
 @if($user->estAdmin())
  <a class='btn' href='{{ route('admin.index') }}'>Panel admin</a>
@endif
<form method='POST' action='{{ route('logout') }}' style='display:inline'>
  @csrf
  <button class='btn' style='background:#757575'>Déconnexion</button>
</form>
 <form method='POST' action='{{ route('profil.photo') }}' enctype='multipart/form-data'>
 @csrf
 <input type='file' name='photo' accept='image/*' required>
 <button class='btn'>Changer la photo</button>
 </form>
</div>
@unless($user->estAdmin())
<div class='carte'>
 <h2>Abonnement</h2>
 @if($actif)
 <p>Actif jusqu'au {{ $actif->date_fin->format('d/m/Y') }}.</p>
 @else
 <p>Aucun abonnement actif.</p>
 @endif
 <a class='btn' href='{{ route('abonnement.index') }}'>Faire un abonnement</a>
 <a class='btn' href='{{ route('horaires.edit') }}'>Horaire</a>
</div>
@endunless
<div class='carte'>
 <h2>Rendez-vous à venir</h2>
 @forelse($rdvs as $r)
 <p>{{ $r->date_heure->format('d/m/Y H:i') }} – {{ $r->demandeur->pseudo }} avec {{ $r->fournisseur->pseudo }}</p>
 @empty
 <p>Aucun rendez-vous.</p>
 @endforelse
</div>
<div class='carte'>
 <h2>Mes offres ({{ $offres->count() }})</h2>
 @foreach($offres as $o) <p>{{ $o->titre }} <span class='badge'>{{ $o->categorie->nom }}</span></p> @endforeach
 <h2>Mes demandes ({{ $demandes->count() }})</h2>
 @foreach($demandes as $d) <p>{{ $d->titre }}</p> @endforeach
</div>
@endsection