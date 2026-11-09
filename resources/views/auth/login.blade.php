@extends('layouts.app')
@section('titre', 'Connexion')
@section('contenu')
<div class='carte'>
 <h1>Connexion</h1>
 <form method='POST' action='{{ route('login.store') }}'>
 @csrf
 <label>Pseudo</label><input name='pseudo' value='{{ old('pseudo') }}' required>
 <label>Mot de passe</label><input type='password' name='password' required>
 <label><input type='checkbox' name='remember' style='width:auto'> Rester connecté</label>
 <p><button class='btn'>Se connecter</button></p>
 </form>
 <p><a href='{{ route('register') }}'>Créer un compte</a> · <a href='{{ route('password.request') }}'>Mot de passe ou
 blié</a></p>
</div>
@endsection