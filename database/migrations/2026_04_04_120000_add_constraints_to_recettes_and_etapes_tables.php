<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Si une ancienne recette n'a pas d'auteur, on met une valeur simple
        // avant de rendre la colonne obligatoire.
        DB::table('recettes')
            ->whereNull('auteur')
            ->update(['auteur' => 'Auteur inconnu']);

        // Les commandes SQL ci-dessous sont specifiques a MySQL.
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        // L'auteur devient obligatoire au niveau base.
        DB::statement("ALTER TABLE recettes MODIFY auteur VARCHAR(255) NOT NULL");

        // Le temps de preparation doit etre strictement superieur a 0.
        DB::statement("ALTER TABLE recettes ADD CONSTRAINT chk_temps_preparation_positif CHECK (temps_preparation > 0)");

        // Le numero de l'etape doit etre strictement superieur a 0.
        DB::statement("ALTER TABLE etapes ADD CONSTRAINT chk_numero_etape_positif CHECK (numero_etape > 0)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE etapes DROP CONSTRAINT chk_numero_etape_positif");
        DB::statement("ALTER TABLE recettes DROP CONSTRAINT chk_temps_preparation_positif");
        DB::statement("ALTER TABLE recettes MODIFY auteur VARCHAR(255) NULL");
    }
};
