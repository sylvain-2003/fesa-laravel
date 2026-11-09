@extends('layouts.app')
@section('titre', 'Faire une demande')
@section('contenu')
<div class='carte'>
 <h1>Faire une demande</h1>
 <form method='POST' action='{{ route('demandes.store') }}'>
 @csrf
 <label>Catégorie</label>
 <select name='categorie_id' required>
 @foreach($categories as $c) <option value='{{ $c->id }}'>{{ $c->nom }}</option> @endforeach
 </select>
 <label>Titre</label><input name='titre' value='{{ old('titre') }}' required>
 <label>Description</label><textarea name='description' rows='4' required>{{ old('description') }}</textarea>
 <label>Budget (F CFA)</label><input type='number' name='budget' value='{{ old('budget') }}'>
 <button class='btn'>Valider</button>
 </form>
</div>
@endsection
