<?php

namespace App\Http\Middleware;

use Closure;

class RixRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    protected $notaccessable = [
        'rix_messages',
        'rix_action_messages',
        'rix_subscriptions',
        'rix_action_subscriptions',
        'rix_users',
        'rix_action_users',
        'rix_user',
        'rix_action_user'
    ];

    public function handle($request, Closure $next)
    {
        if (\Auth::check()) {
            if (\Auth::user()->role != 'admin' && in_array(\Request::route()->getName(), $this->notaccessable))
                abort(403);
            return $next($request);
        }
        return redirect()->route('rix_login');
    }
}
