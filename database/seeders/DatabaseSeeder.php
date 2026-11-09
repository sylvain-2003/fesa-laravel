<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\PlanAbonnement;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Agence immobilière',
            'Autos, motos et meubles',
            'Boutiques et supermarchés',
            'Prestation de services',
            'RH et compétences',
        ];
        foreach ($categories as $nom) {
            Categorie::firstOrCreate(['nom' => $nom]);
        }
        // Tarifs repris du cahier des charges, modifiables
        $plans = [['1 mois', 1, 1500], ['3 mois', 3, 3500], ['6 mois', 6, 6000], ['12 mois', 12, 10000]];
        foreach ($plans as [$nom, $duree, $prix]) {
            PlanAbonnement::firstOrCreate(['nom' => $nom], ['duree_mois' => $duree, 'prix' => $prix]);
        }
        User::firstOrCreate(['pseudo' => 'admin'], [
            'nom' => 'Administrateur',
            'email' => 'admin@fesa.test',
            'password' => 'ChangezMoi123',
            'role' => 'admin',
            'type_membre' => 'professionnel',
        ]);
    }
}