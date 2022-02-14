<?php

namespace x96\SocialitePassport\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasAction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $actions
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$actions)
    {
        $user = Auth::user();

        $isApiReguest = false;
        if (Auth::guard('api')->check())
        {
            $isApiReguest = true;
        }

        if ($user->hasAction($actions)) {
            return $next($request);
        }

        if ($isApiReguest) {
            return response()->json(['message' => 'You not permission for this Action.', 'permissions' => $user->permissions], 403);
        }

        abort(403, 'Unauthorized action.');
    }
}
