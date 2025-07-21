<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    /**
     * Gère une requête entrante.
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si un utilisateur est connecté via Auth
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Vous devez être connecté en tant qu\'administrateur.');
        }

        return $next($request);
    }
}
