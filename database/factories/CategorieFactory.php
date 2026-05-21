<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Categorie>
 */
class CategorieFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Nom simple et unique pour eviter les collisions.
            //unique => chaque cat a un nom différent/ words() => 2 mots en string 
            'nom_categorie' => fake()->unique()->words(2, true),
        ];
    }
}
