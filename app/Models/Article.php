<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateur;
use App\Models\Commande;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';

    protected $fillable = [
        'titre',
        'description',
        'image',
        'prix',
        'utilisateur_id',
        'en_ligne',
         
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'en_ligne' => 'boolean',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    // Relation many-to-many avec Commande
    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_articles')
            ->withPivot('quantite', 'prix_unitaire')
            ->withTimestamps();
    }
}
