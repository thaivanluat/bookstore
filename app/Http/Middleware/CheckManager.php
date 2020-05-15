<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use View;

class CheckManager
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
        $position = $user->chucvu;

        if($position == 'staff') {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
