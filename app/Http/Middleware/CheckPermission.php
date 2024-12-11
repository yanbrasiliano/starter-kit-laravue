<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class CheckPermission
{
    public function handle(Request $request, Closure $next)
    {

        $user = auth()->user();
        $permission = Route::currentRouteName();

        $permissions = str_contains($permission, 'view')
          ? [$permission, str_replace('view', 'edit', $permission)]
          : [$permission];

        if (!$user->canAny($permissions)) {
            throw new Exception('Você não tem permissão para realizar esta ação.', HttpResponse::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
