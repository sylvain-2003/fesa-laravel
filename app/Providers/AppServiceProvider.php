<?php

namespace App\Providers;

use App\Models\Categorie;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Données disponibles dans le layout : catégories de la barre de recherche et alertes non lues
        View::composer('layouts.app', function ($view) {
            /** @var User|null $user */
            $user = Auth::user();

            $view->with([
                'categoriesMenu' => Categorie::orderBy('nom')->get(),
                'alertesNonLues' => $user ? $user->alertes()->where('lu', false)->count() : 0,
            ]);
        });
    }
}