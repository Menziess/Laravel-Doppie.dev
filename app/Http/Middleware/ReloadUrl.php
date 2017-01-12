<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReloadUrl
{
    /**
     * Run the request filter to check whether the user
     * has been inactive for 7 seconds, and needs a url
     * reload to get transferred back to his page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($session = DB::table('sessions')
            ->where('user_id', Auth::id())
            ->where('last_activity', '<', Carbon::now()->subSeconds(7)->timestamp)
            ->get()) {
            DB::table('sessions')->where('user_id', Auth::id())->update(['url' => null]);
            if (isset($session[0]->url)) {
                return redirect($session[0]->url);
            }
        } else {
            DB::table('sessions')->where('user_id', Auth::id())->update(['url' => null]);
        }

        return $next($request);
    }
}
