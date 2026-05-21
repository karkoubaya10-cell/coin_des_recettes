<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Table d'archive: on stocke seulement les infos de la recette supprimee.
        Schema::create('recettes_archive', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recette_id_originale');
            $table->string('auteur');
            $table->string('titre');
            $table->text('description');
            $table->text('ingredients');
            $table->integer('temps_preparation');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->timestamp('created_at_original')->nullable();
            $table->timestamp('updated_at_original')->nullable();
            $table->timestamp('date_archivage')->useCurrent();
        });

        // Trigger SQL uniquement pour MySQL/MariaDB.
        // En SQLite (tests), on saute cette partie.
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        DB::unprepared('DROP TRIGGER IF EXISTS trg_archive_recette_before_delete');

        // Avant suppression d'une recette, on la copie dans la table archive.
        DB::unprepared('
            CREATE TRIGGER trg_archive_recette_before_delete
            BEFORE DELETE ON recettes
            FOR EACH ROW
            BEGIN
                INSERT INTO recettes_archive (
                    recette_id_originale,
                    auteur,
                    titre,
                    description,
                    ingredients,
                    temps_preparation,
                    image,
                    user_id,
                    categorie_id,
                    created_at_original,
                    updated_at_original,
                    date_archivage
                ) VALUES (
                    OLD.id,
                    OLD.auteur,
                    OLD.titre,
                    OLD.description,
                    OLD.ingredients,
                    OLD.temps_preparation,
                    OLD.image,
                    OLD.user_id,
                    OLD.categorie_id,
                    OLD.created_at,
                    OLD.updated_at,
                    NOW()
                );
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::unprepared('DROP TRIGGER IF EXISTS trg_archive_recette_before_delete');
        }

        Schema::dropIfExists('recettes_archive');
    }
};
