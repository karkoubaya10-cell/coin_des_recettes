<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\Recette;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Recette>
 */
class RecetteFactory extends Factory
{
    /**
     * Liste des auteurs possibles pour les recettes de demo.
     */
    private const AUTEURS = [
        'Sara Benali',
        'Youssef Alaoui',
        'Imane Tahiri',
        'Omar El Idrissi',
        'Salma Berrada',
        'Mehdi Amrani',
        'Nadia Lahlou',
        'Ayoub Mansouri',
        'Khadija Ziani',
        'Anas Chraibi',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Auteur choisi aleatoirement depuis la liste fixe.
            'auteur' => $this->randomAuteur(),
            // Donnees principales de la recette.
            'titre' => $this->faker->sentence(3),//3 mots
            'description' => $this->faker->paragraph(),
            'ingredients' => $this->faker->sentence(6),
            'temps_preparation' => $this->faker->numberBetween(10, 60),
            // Image laissee nulle par defaut 
            'image' => null,
            // Si non fournis, la factory cree un user et une categorie automatiquement.
            'user_id' => User::factory(),
            'categorie_id' => Categorie::factory(),
        ];
    }

    /**
     * Retourne un auteur au hasard depuis la liste fixe.
     */
    private function randomAuteur(): string
    {
        return $this->faker->randomElement(self::AUTEURS);
    }
}
