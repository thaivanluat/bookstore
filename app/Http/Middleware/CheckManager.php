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
        $roles = Session::get('role');

        // $position = $user->chucvu;

        if(!\in_array(1, $roles) || !\in_array(2, $roles)) {
            abort(403, 'Unauthorized action.');
        }
        
        return $next($request);
    }
}
