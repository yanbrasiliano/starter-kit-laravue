<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\{Request, Response as HttpResponse};
use Illuminate\Support\Facades\Route;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();
        $permission = Route::currentRouteName();

        if (str_contains($permission, 'view')) {
            $permission = [
                $permission,
                str_replace('view', 'edit', $permission),
            ];
        }

        if (!$user->canAny($permission)) {
            throw new Exception('Você não tem permissão para realizar esta ação.', HttpResponse::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
