@extends('layouts.app')
@section('titre', 'Mot de passe oublié')
@section('contenu')
<div class='carte'>
 <h1>Mot de passe oublié</h1>
 <form method='POST' action='{{ route('password.email') }}'>
 @csrf
 <label>Votre e-mail</label><input type='email' name='email' required>
 <button class='btn'>Soumettre</button>
 </form>
</div>
@endsection