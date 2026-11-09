{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')
@section('titre', 'Créer un compte')
@section('contenu')
<div class='carte'>
 <h1>Créer un compte</h1>
 <form method='POST' action='{{ route('register.store') }}'>
 @csrf
 <label>Type de membre</label>
<select name='type_membre' id='type_membre' required>
  <option value='particulier' @selected(old('type_membre') === 'particulier')>Particulier</option>
  <option value='entreprise' @selected(old('type_membre') === 'entreprise')>Entreprise</option>
</select>

<div id='bloc-nif' style='display:none'>
  <label>NIF de l’entreprise</label>
  <input name='nif' id='nif' value='{{ old('nif') }}' placeholder='Numéro d’identification fiscale'>
</div>

<label id='label-piece'>Pièce d’identité</label>
<select name='type_piece' id='type_piece'>
  <option value=''>— Choisir le type de pièce —</option>
  <option value='cni' @selected(old('type_piece') === 'cni')>Carte d’identité nationale</option>
  <option value='passeport' @selected(old('type_piece') === 'passeport')>Passeport</option>
</select>

<div id='bloc-numero' style='display:none'>
  <label id='label-numero'>Numéro de la pièce</label>
  <input name='numero_piece' id='numero_piece' value='{{ old('numero_piece') }}'>
</div>
 <label>Pseudo</label><input name='pseudo' value='{{ old('pseudo') }}' required>
 <label>Nom complet</label><input name='nom' value='{{ old('nom') }}' required>
 <label>E-mail</label><input type='email' name='email' value='{{ old('email') }}' required>
 <label>Mot de passe</label><input type='password' name='password' required>
 <label>Confirmer le mot de passe</label><input type='password' name='password_confirmation' required>
 <button class='btn'>Créer</button>
 </form>
</div>
<script>
  const type = document.getElementById('type_membre');
  const piece = document.getElementById('type_piece');

  function maj() {
    const ent = type.value === 'entreprise';
    document.getElementById('bloc-nif').style.display = ent ? 'block' : 'none';
    document.getElementById('nif').required = ent;
    document.getElementById('label-piece').textContent = ent ? 'Pièce d’identité du responsable' : 'Pièce d’identité';

    const choisie = piece.value !== '';
    document.getElementById('bloc-numero').style.display = choisie ? 'block' : 'none';
    document.getElementById('numero_piece').required = choisie;
    document.getElementById('label-numero').textContent =
      'Numéro ' + (piece.value === 'passeport' ? 'du passeport' : 'de la carte d’identité') + (ent ? ' du responsable' : '');
  }

  type.addEventListener('change', maj);
  piece.addEventListener('change', maj);
  maj();
</script>
@endsection