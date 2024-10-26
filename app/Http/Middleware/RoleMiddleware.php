<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Enums\RoleEnum;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $roleId
     * @return mixed
     */
    public function handle(Request $request, Closure $next, INT $roleId): mixed
    {
        $user = auth('api')->user();
        if (!$user || $user->role_id !== $roleId) {
            return response()->json(['message' => 'Acesso negado: você não possui permissão para acessar este recurso.'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
