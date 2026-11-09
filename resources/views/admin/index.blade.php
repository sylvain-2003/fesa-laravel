@extends('layouts.app')
@section('titre', 'Panel admin')
@section('contenu')
@include('admin.menu')
<div class='carte'>
 <h2>Mettre une information</h2>
 <form method='POST' action='{{ route('admin.information') }}'>
 @csrf
 <textarea name='contenu' rows='3' required></textarea>
 <button class='btn'>OK</button>
 </form>
</div>
<div class='carte'>
 <h2>Dernières informations</h2>
 @forelse($informations as $i) <p>{{ $i->created_at->format('d/m/Y') }} – {{ $i->contenu }}</p> @empty <p>Aucune info
 rmation.</p> @endforelse
</div>
@endsection