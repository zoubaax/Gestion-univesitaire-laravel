<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isProfessor())) {
            return $next($request);
        }

        return redirect()->route('etudiants.index')->with('error', 'Accès restreint. Seuls les professeurs et administrateurs peuvent effectuer cette action.');
    }
}
