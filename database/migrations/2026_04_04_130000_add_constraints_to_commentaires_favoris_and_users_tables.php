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
        // On remplit les dates nulles avant de rendre les champs obligatoires.
        DB::table('commentaires')
            ->whereNull('date_commentaire')
            ->update(['date_commentaire' => now()->toDateString()]);

        DB::table('favoris')
            ->whereNull('date_ajout')
            ->update(['date_ajout' => now()->toDateString()]);

        // Les commandes SQL ci-dessous sont specifiques a MySQL.
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        // Le commentaire doit avoir une vraie date.
        DB::statement("ALTER TABLE commentaires MODIFY date_commentaire DATE NOT NULL");

        // La date d'ajout d'un favori devient obligatoire.
        DB::statement("ALTER TABLE favoris MODIFY date_ajout DATE NOT NULL");

        // Le contenu du commentaire ne doit pas etre vide.
        DB::statement("ALTER TABLE commentaires ADD CONSTRAINT chk_commentaire_non_vide CHECK (CHAR_LENGTH(TRIM(contenu)) > 0)");

        // Le role doit rester simple : admin ou user.
        DB::statement("ALTER TABLE users ADD CONSTRAINT chk_role_valide CHECK (role IN ('admin', 'user'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE users DROP CONSTRAINT chk_role_valide");
        DB::statement("ALTER TABLE commentaires DROP CONSTRAINT chk_commentaire_non_vide");
        DB::statement("ALTER TABLE favoris MODIFY date_ajout DATE NULL");
        DB::statement("ALTER TABLE commentaires MODIFY date_commentaire DATE NULL");
    }
};
