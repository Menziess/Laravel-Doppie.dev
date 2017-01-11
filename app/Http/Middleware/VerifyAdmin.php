<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAdmin
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->is_admin) {
            return redirect('/game');
        }

        return $next($request);
    }
}
