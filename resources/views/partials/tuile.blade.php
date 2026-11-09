{{-- resources/views/partials/tuile.blade.php --}}
<a class='tuile' href='{{ route('offres.show', $offre) }}'
   @if($offre->image) style="background-image:url('{{ asset('storage/' . $offre->image) }}')" @endif>
  @if($offre->video)<div class='lecture'>▶</div>@endif
  <span>{{ Str::limit($offre->titre, 40) }}</span>
</a>