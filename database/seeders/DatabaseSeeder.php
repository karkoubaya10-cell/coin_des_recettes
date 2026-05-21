<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Commentaire;
use App\Models\Favori;
use App\Models\Recette;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    // Flux des seeders :
    // 1. Création des catégories fixes
    // 2. Préparation de la liste des auteurs
    // 3. Création des utilisateurs (fixes + aléatoires)
    // 4. Génération des recettes (factory + sequence pour les relations)
    // 5. Enrichissement des recettes : étapes, commentaires, favoris
    // Résultat : base de données complète de démonstration

    /**
     * Seed the application's database.
     */
    //Crée : 4 catégories (Entrées, Plats, Desserts, Boissons), 
    //2 comptes fixes (admin + user), 3 users aléatoires via factory, 
    //10 recettes, chaque recette avec 3 étapes + 2 commentaires + favoris.
    public function run(): void
    {
        // 1) Creation des categories fixes (Entrees, Plats, Desserts, Boissons).
        $categories = $this->createCategories();
        // Liste d'auteurs de demonstration.
        $auteurs = $this->auteurs();

        // 2) Creation des utilisateurs de demo (admin + user + users aleatoires).
        [$admin, $user, $utilisateursPourRecettes] = $this->createUsers();

        // 3) Insertion des recettes via la factory.
        $recettes = $this->createRecettes($auteurs, $categories, $utilisateursPourRecettes);

        // 4) Pour chaque recette: etapes + commentaires + favoris.
        $this->enrichRecettes($recettes, $admin, $user);
    }

    /**
     * Cree (ou recupere) les categories principales.
     */
    private function createCategories(): Collection
    {
        //si cat n'existe pas => creer sinon n'joute pas une 2eme fois 
        return collect(['Entrees', 'Plats', 'Desserts', 'Boissons'])
            ->map(fn (string $nom) => Categorie::firstOrCreate(['nom_categorie' => $nom]));
    }

    /**
     * Liste fixe des auteurs utilises pour les recettes de demo.
     */
    private function auteurs(): Collection
    {
        return collect([
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
        ]);
    }

    /**
     * Cree les comptes de base et renvoie:
     * [admin, user, collection_des_users_pour_recettes].
     */
    private function createUsers(): array
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin2@test.com'],
            ['name' => 'Admin', 'password' => bcrypt('123456'), 'role' => 'admin']
        );

        $user = User::updateOrCreate(
            ['email' => 'user@test.com'],
            ['name' => 'User Demo', 'password' => bcrypt('123456'), 'role' => 'user']
        );

        $utilisateursDemo = User::factory(3)->create();
        $utilisateursPourRecettes = collect([$admin, $user])->merge($utilisateursDemo)->values();

        return [$admin, $user, $utilisateursPourRecettes];
    }

    /**
     * Cree les recettes et repartit auteurs/users/categories de facon cyclique.
     */
    private function createRecettes(Collection $auteurs, Collection $categories, Collection $users): Collection
    {
        return Recette::factory($auteurs->count())
            ->sequence(
                ...$auteurs->map(function (string $auteur, int $index) use ($categories, $users) {
                    return [
                        'auteur' => $auteur,
                        'user_id' => $users[$index % $users->count()]->id,
                        'categorie_id' => $categories[$index % $categories->count()]->id,
                    ];
                })->all()
            )
            ->create();
    }

    /**
     * Ajoute des etapes, commentaires et favoris a chaque recette.
     */
    private function enrichRecettes(Collection $recettes, User $admin, User $user): void
    {
        $recettes->each(function (Recette $recette, int $index) use ($admin, $user) {
            $this->createEtapes($recette);
            $this->createCommentaires($recette, $admin, $user);
            $this->createFavoris($recette, $index, $admin, $user);
        });
    }

    /**
     * Reinitialise puis ajoute les etapes de base d'une recette.
     */
    private function createEtapes(Recette $recette): void
    {
        $recette->etapes()->delete();

        $recette->etapes()->createMany([
            ['numero_etape' => 1, 'description' => 'Preparer tous les ingredients necessaires.'],
            ['numero_etape' => 2, 'description' => 'Realiser la cuisson selon la recette.'],
            ['numero_etape' => 3, 'description' => 'Servir la recette de facon soignee.'],
        ]);
    }

    /**
     * Ajoute 2 commentaires de demonstration par recette.
     */
    private function createCommentaires(Recette $recette, User $admin, User $user): void
    {
        Commentaire::firstOrCreate(
            [
                'contenu' => 'Tres bonne recette, facile a refaire a la maison.',
                'user_id' => $admin->id,
                'recette_id' => $recette->id,
            ],
            ['date_commentaire' => now()->toDateString()]
        );

        Commentaire::firstOrCreate(
            [
                'contenu' => 'Merci pour le partage, le resultat etait excellent.',
                'user_id' => $user->id,
                'recette_id' => $recette->id,
            ],
            ['date_commentaire' => now()->toDateString()]
        );
    }

    /**
     * Admin favorite toutes les recettes.
     * User favorite une recette sur deux (index pair).
     */
    private function createFavoris(Recette $recette, int $index, User $admin, User $user): void
    {
        Favori::firstOrCreate(
            ['user_id' => $admin->id, 'recette_id' => $recette->id],
            ['date_ajout' => now()->toDateString()]
        );

        if ($index % 2 === 0) {
            Favori::firstOrCreate(
                ['user_id' => $user->id, 'recette_id' => $recette->id],
                ['date_ajout' => now()->toDateString()]
            );
        }
    }
}
