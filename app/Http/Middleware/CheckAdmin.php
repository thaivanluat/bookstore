<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use View;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Session::get('user');
        $userId = $user->manguoidung;

        if($userId != 1) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
