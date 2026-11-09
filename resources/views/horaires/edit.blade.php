@extends('layouts.app')
@section('titre', 'Mon horaire')
@section('contenu')
<div class='carte'>
 <h1>Mon horaire de service</h1>
 <p>Laissez vide les jours où vous ne travaillez pas.</p>
 <form method='POST' action='{{ route('horaires.update') }}'>
 @csrf
 <table>
 <tr><th>Jour</th><th>Début</th><th>Fin</th></tr>
 @foreach($jours as $jour)
 <tr>
 <td>{{ $jour }}</td>
 <td><input type='time' name='horaires[{{ $jour }}][debut]' value='{{ isset($horaires[$jour]) ? substr($horaires[$jour]->heure_debut, 0, 5) : '' }}'></td>
 <td><input type='time' name='horaires[{{ $jour }}][fin]' value='{{ isset($horaires[$jour]) ? substr($horaires[$jour]->heure_fin, 0, 5) : '' }}'></td>
 </tr>
 @endforeach
 </table>
 <button class='btn'>OK</button>
 </form>
</div>
@endsection