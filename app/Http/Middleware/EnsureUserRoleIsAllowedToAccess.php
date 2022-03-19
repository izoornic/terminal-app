<?php

namespace App\Http\Middleware;

use App\Models\PozicijaPrikazStranica;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class EnsureUserRoleIsAllowedToAccess
{
    // dashboard, pages, navigation-menus

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        try {
            $userRole = auth()->user()->pozicija_tipId;
            $currentRouteName = Route::currentRouteName();

            if (PozicijaPrikazStranica::isRoleHasRightToAccess($userRole, $currentRouteName)) {
                return $next($request);
            } else {
                abort(403, 'Unauthorized action 2.');
            }
        } catch (\Throwable $th) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * The default user access role.
     *
     * @return void
     */
    private function defaultUserAccessRole()
    {
        return [
            'admin' => [
                'user-permissions',
            ],
        ];
    }
}