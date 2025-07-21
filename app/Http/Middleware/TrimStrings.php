<?php
namespace App\Http\Middleware;

class TrimStrings
{
    /**
     * Les noms d'attributs à ne pas trimmer (optionnel).
     *
     * @var array<int, string>
     */
    protected $except = [
        // Exemple : 'password', 'password_confirmation'
    ];
}