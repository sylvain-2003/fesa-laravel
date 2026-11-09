@extends('layouts.app')
@section('titre', 'Publier une offre')
@section('contenu')
<div class='carte'>
 <h1>{{ $type === 'speciale' ? 'Faire une offre spéciale' : 'Publier une offre' }}</h1>
 <form method='POST' action='{{ route('offres.store') }}' enctype='multipart/form-data'>
 @csrf
 <input type='hidden' name='type' value='{{ $type }}'>
 <label>Catégorie</label>
 <select name='categorie_id' required>
 @foreach($categories as $c)
  <option value='{{ $c->id }}' @selected(request('categorie') == $c->id)>{{ $c->nom }}</option>
 @endforeach
 </select>
 <label>Titre</label><input name='titre' value='{{ old('titre') }}' required>
 <label>Description</label><textarea name='description' rows='4' required>{{ old('description') }}</textarea>
 <label>Prix (F CFA)</label><input type='number' name='prix' value='{{ old('prix') }}'>
 @if($type === 'speciale')
    <label>Prix promotionnel (F CFA)</label><input type='number' name='prix_promo' value='{{ old('prix_promo') }}' r
    equired>
    <label>Fin de la promotion</label><input type='date' name='date_fin' value='{{ old('date_fin') }}'>
 @endif
 <label>Image</label><input type='file' name='image' accept='image/*'>
 <button class='btn'>Valider</button>
 <label>Vidéo (facultatif, MP4 ou WebM, 20 Mo maximum)</label>
 <input type='file' name='video' accept='video/mp4,video/webm'>
 </form>
</div>
@endsection