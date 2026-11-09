<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EstAbonne
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && ! $user->estAdmin() && ! $user->estAbonne()) {
            return redirect()->route('abonnement.index')
                ->with('erreur', 'Un abonnement est requis pour cette action.');
        }
        return $next($request);
    }
}