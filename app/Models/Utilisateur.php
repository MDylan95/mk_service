<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ← changement ici
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Article;

class Utilisateur extends Authenticatable
{
    use HasFactory;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relation avec article
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
