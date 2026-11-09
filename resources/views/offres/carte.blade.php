<div class='carte'>
 @if($offre->image)
 <img src='{{ asset('storage/' . $offre->image) }}' alt='' style='max-width:100%;border-radius:8px'>
 @endif
 <span class='badge'>{{ $offre->categorie->nom }}</span>
 @if($offre->type === 'speciale') <span class='badge'>Offre spéciale</span> @endif
 <h3>{{ $offre->titre }}</h3>
 <p>{{ Str::limit($offre->description, 120) }}</p>
 <p>
 @if($offre->type === 'speciale')
 <s>{{ number_format($offre->prix ?? 0, 0, ',', ' ') }} F</s>
 <strong>{{ number_format($offre->prix_promo, 0, ',', ' ') }} F</strong>
 @elseif($offre->prix)
 <strong>{{ number_format($offre->prix, 0, ',', ' ') }} F</strong>
 @endif
 </p>
 <p>Par
 @auth <a href='{{ route('membres.show', $offre->user) }}'>{{ $offre->user->pseudo }}</a>
 @else {{ $offre->user->pseudo }} @endauth
 </p>
 @auth
 <details>
 <summary>Commenter ({{ $offre->commentaires->count() }})</summary>
 @foreach($offre->commentaires->take(3) as $c)
 <p><strong>{{ $c->user->pseudo }}</strong> : {{ $c->contenu }}</p>
 @endforeach
 <form method='POST' action='{{ route('commentaires.store', $offre) }}'>
 @csrf
 <textarea name='contenu' rows='2' required></textarea>
 <button class='btn'>Valider</button>
 </form>
 </details>
 @endauth
</div>