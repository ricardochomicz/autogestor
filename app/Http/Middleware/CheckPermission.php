<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();

        if (!$user || !$user->hasPermission($permission)) {
            abort(403, 'Você não tem permissão para acessar esta rota.Entre em contato com o administrador do sistema.');
        }

        return $next($request);
    }
}
