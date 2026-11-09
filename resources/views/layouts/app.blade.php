<!DOCTYPE html>
<html lang='fr'>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>@yield('titre', 'FeSA') – FeSA</title>
<style>
 :root{--c:#4CAF50;--cf:#388E3C;--bg:#ffffff;--gris:#6b6a66}
 *{box-sizing:border-box}
 body{margin:0;font-family:Arial,sans-serif;background:var(--bg);color:#222;min-height:100vh;display:flex;flex-direction:column}
 main{flex:1;width:100%;max-width:1000px;margin:0 auto;padding:12px}

 /* En-tête vert */
 .barre{background:var(--c);display:flex;align-items:center;gap:6px;padding:8px 10px;position:sticky;top:0;z-index:10}
 .barre a{color:#111;text-decoration:none;font-size:14px;padding:6px 8px;position:relative}
 .logo{color:#fff !important;font-size:26px !important}
 .espace{flex:1}
 .pastille{background:#d32f2f;color:#fff;border-radius:10px;font-size:10px;padding:1px 5px;position:absolute;top:0;right:-2px}
 .avatar{display:inline-flex;width:34px;height:34px;border-radius:50%;background:#e8e8e8;align-items:center;justify-content:center;overflow:hidden;font-size:12px}
 .avatar img{width:100%;height:100%;object-fit:cover}

 /* Barre de recherche */
 .recherche{display:flex;align-items:center;gap:8px;padding:10px;border-bottom:1px solid #ddd}
 .recherche select{width:auto;max-width:34%;font-size:13px;border:0;background:none;margin:0;padding:4px}
 .champ{flex:1;display:flex;align-items:center;border:1px solid #bbb;border-radius:20px;padding:0 8px}
 .champ input{border:0;margin:0;padding:8px 4px;font-size:15px;outline:none}
 .champ button{background:none;border:0;font-size:17px;cursor:pointer;padding:4px}

 /* Accueil */
 .hero{text-align:left;padding:10px 4px 6px}
 .hero-haut{display:flex;justify-content:space-between;align-items:center}
 .hero h1{font-size:21px;margin:0}
 .panier{font-size:30px;text-decoration:none}
 .actions{display:flex;justify-content:flex-end;gap:8px;margin:10px 0}
 .action{display:inline-flex;align-items:center;gap:5px;font-size:12px;color:#111;text-decoration:none}
 .action b{background:#333;color:#fff;border-radius:50%;width:22px;height:22px;display:inline-flex;align-items:center;justify-content:center;font-size:12px}
 .slogan{text-align:center;font-size:16px;margin:18px 0}
 .titre-rangee{display:flex;justify-content:space-between;border-top:1px solid #333;border-bottom:1px solid #ddd;padding:8px 2px;margin:14px 0 10px;font-weight:bold;font-size:14px}
 .titre-rangee a{font-weight:normal;font-size:13px;color:var(--cf)}
 .rangee{display:flex;gap:10px;overflow-x:auto;scroll-snap-type:x mandatory;padding-bottom:8px}
 .tuile{flex:0 0 118px;height:128px;border-radius:12px;background:var(--gris) center/cover no-repeat;position:relative;overflow:hidden;scroll-snap-align:start;text-decoration:none;color:#fff;display:block}
 .tuile span{position:absolute;left:0;right:0;bottom:0;padding:16px 6px 5px;font-size:11px;background:linear-gradient(transparent,rgba(0,0,0,.75))}
 .tuile .lecture{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:34px;background:rgba(255,255,255,.85);color:#111;border-radius:50%;width:44px;height:44px;display:flex;align-items:center;justify-content:center}
 .vide{color:#888;font-size:13px}

 /* Pied de page */
 .pied{background:var(--c);color:#111;text-align:center;font-size:13px;font-weight:bold;padding:14px}

 /* Cartes et formulaires des autres pages */
 .carte{background:#fff;border-radius:10px;padding:16px;margin-bottom:14px;border:1px solid #e3e3e3}
 .grille{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px}
 input,select,textarea{width:100%;padding:10px;margin:4px 0 12px;border:1px solid #ccc;border-radius:6px;font-size:16px}
 .btn{background:var(--c);color:#fff;border:0;padding:10px 16px;border-radius:6px;font-size:16px;cursor:pointer;text-decoration:none;display:inline-block}
 .ok{background:#e8f5e9;color:#1b5e20;padding:10px;border-radius:6px;margin-bottom:12px}
 .err{background:#fcebeb;color:#791f1f;padding:10px;border-radius:6px;margin-bottom:12px}
 .badge{background:#e8f5e9;color:#1b5e20;padding:2px 8px;border-radius:10px;font-size:12px}
 table{width:100%;border-collapse:collapse} td,th{padding:8px;border-bottom:1px solid #eee;text-align:left}
</style>
</head>
<body>

<header>
  <nav class='barre'>
    <a class='logo' href='{{ route('accueil') }}'>★</a>
    <span class='espace'></span>
    <a href='{{ route('offres.index') }}'>Offres</a>
    <a href='{{ route('demandes.index') }}'>Demandes</a>
    <a href='{{ route('alertes.index') }}'>Notifications
      @if($alertesNonLues > 0)<span class='pastille'>{{ $alertesNonLues }}</span>@endif
    </a>
    <a href='{{ auth()->check() ? route('profil.edit') : route('login') }}'>
      @auth
        <span class='avatar'>
          @if(auth()->user()->photo)<img src='{{ asset('storage/' . auth()->user()->photo) }}' alt=''>
          @else {{ strtoupper(substr(auth()->user()->pseudo, 0, 1)) }} @endif
        </span>
      @else
        Connexion
      @endauth
    </a>
  </nav>

  <form class='recherche' method='GET' action='{{ route('recherche') }}'>
    <select name='categorie'>
      <option value=''>Toutes catégories</option>
      @foreach($categoriesMenu as $cat)
        <option value='{{ $cat->id }}' @selected(request('categorie') == $cat->id)>{{ $cat->nom }}</option>
      @endforeach
    </select>
    <div class='champ'>
      <input name='q' value='{{ request('q') }}' placeholder='Rechercher un produit'>
      <button type='button' title='Rechercher par image' onclick="document.getElementById('champ-image').click()">📷</button>
      <button type='submit' title='Rechercher'>🔍</button>
    </div>
    <svg width='28' height='20' viewBox='0 0 28 20' aria-label='Togo'>
      <rect width='28' height='20' fill='#006A4E'/>
      <rect y='4' width='28' height='4' fill='#FFCE00'/>
      <rect y='12' width='28' height='4' fill='#FFCE00'/>
      <rect width='12' height='12' fill='#D21034'/>
      <polygon points='6,2.5 6.88,5.09 9.61,5.13 7.43,6.76 8.23,9.37 6,7.8 3.77,9.37 4.57,6.76 2.39,5.13 5.12,5.09' fill='#fff'/>
    </svg>
  </form>
  <form method='POST' action='{{ route('recherche.image') }}' enctype='multipart/form-data' style='display:none'>
  @csrf
  <input type='file' name='image' id='champ-image' accept='image/*' capture='environment' onchange='this.form.submit()'>
</form>
</header>

<main>
  @if(session('succes'))<div class='ok'>{{ session('succes') }}</div>@endif
  @if(session('erreur'))<div class='err'>{{ session('erreur') }}</div>@endif
  @if($errors->any())
    <div class='err'>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
  @endif
  @yield('contenu')
</main>

<footer class='pied'>©{{ date('Y') }} FESA</footer>
</body>
</html>