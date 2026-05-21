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
        // Les procedures stockees sont pour MySQL/MariaDB.
        // En test SQLite, on saute pour eviter les erreurs SQL.
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        // On supprime d'abord si elle existe deja.
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_stats_recettes_par_categorie');

        // Procedure simple: retourne le nombre de recettes par categorie.
        DB::unprepared('
            CREATE PROCEDURE sp_stats_recettes_par_categorie()
            BEGIN
                SELECT
                    c.id AS categorie_id,
                    c.nom_categorie,
                    COUNT(r.id) AS total_recettes
                FROM categories c
                LEFT JOIN recettes r ON r.categorie_id = c.id
                GROUP BY c.id, c.nom_categorie
                ORDER BY c.nom_categorie ASC;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::unprepared('DROP PROCEDURE IF EXISTS sp_stats_recettes_par_categorie');
    }
};
