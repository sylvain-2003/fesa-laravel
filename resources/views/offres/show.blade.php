@extends('layouts.app')
@section('titre', $offre->titre)
@section('contenu')
@if($offre->video)
  <video src='{{ asset('storage/' . $offre->video) }}' controls playsinline style='width:100%;border-radius:10px;margin-bottom:12px'></video>
@endif
@include('offres.carte', ['offre' => $offre])
@endsection