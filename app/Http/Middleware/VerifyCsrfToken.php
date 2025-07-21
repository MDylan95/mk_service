<?php

namespace App\Http\Middleware;

class VerifyCsrfToken
{
    /**
     * Les URIs à exclure de la vérification CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Exemple : 'webhook/*', 'paiement/notification'
    ];
}
