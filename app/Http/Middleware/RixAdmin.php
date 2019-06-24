<?php

namespace App\Http\Middleware;

use App\Models\Users;
use App\User;
use Closure;

class RixAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = new Users();
        if (auth()->check())
            if ($user->accessibility())
                return $next($request);
        return redirect()->route('rix_login');
    }
}
