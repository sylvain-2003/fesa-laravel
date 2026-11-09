@extends('layouts.app')
@section('titre', 'Accès de compte')
@section('contenu')
@include('admin.menu')
<div class='carte' style='overflow-x:auto'>
 <table>
<tr>
    <th>Pseudo</th>
    <th>Type</th>
    <th>NIF</th>
    <th>Pièce</th>
    <th>État</th>
    <th></th>
</tr>
@foreach($membres as $m)
  <tr>
    <td>{{ $m->pseudo }}</td>
    <td>{{ ucfirst($m->type_membre) }}</td>
    <td>{{ $m->nif ?? '—' }}</td>
    <td>{{ $m->type_piece ? strtoupper($m->type_piece) . ' ' . $m->numero_piece : '—' }}</td>
    <td>{{ $m->actif ? 'ON' : 'OFF' }}</td>
    <td>
      <form method='POST' action='{{ route('admin.basculer', $m) }}'>
        @csrf
        <button class='btn'>{{ $m->actif ? 'Passer à OFF' : 'Passer à ON' }}</button>
      </form>
    </td>
  </tr>
@endforeach
 </table>
</div>
@if($membres->previousPageUrl()) <a class='btn' href='{{ $membres->previousPageUrl() }}'>Précédent</a> @endif
@if($membres->nextPageUrl()) <a class='btn' href='{{ $membres->nextPageUrl() }}'>Suivant</a> @endif
@endsection