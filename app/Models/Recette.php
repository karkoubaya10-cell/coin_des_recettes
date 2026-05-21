<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recette extends Model
{
    use HasFactory;

    protected $fillable = [
        'auteur',
        'titre',
        'description',
        'ingredients',
        'temps_preparation',
        'image',
        'user_id',
        'categorie_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }

    public function etapes()
    {
        return $this->hasMany(Etape::class);
    }
}
