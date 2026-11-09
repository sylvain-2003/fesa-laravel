@extends('layouts.app')
@section('titre', 'Nouveau mot de passe')
@section('contenu')
<div class='carte'>
 <h1>Nouveau mot de passe</h1>
 <form method='POST' action='{{ route('password.update') }}'>
 @csrf
 <input type='hidden' name='token' value='{{ $token }}'>
 <input type='hidden' name='email' value='{{ $email }}'>
 <label>Nouveau mot de passe</label><input type='password' name='password' required>
 <label>Confirmer</label><input type='password' name='password_confirmation' required>
 <button class='btn'>Enregistrer</button>
 </form>
</div>
@endsection