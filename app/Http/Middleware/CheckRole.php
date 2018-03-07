<?php

namespace App\Http\Middleware;

use Closure;
use Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // print "request user id -> " . $request->user()->id . ", role param -> " .$role;
        dump("request user id -> " . $request->user()->id . "type : " . gettype($request->user()->id) . ", role param -> " .$role . "type : " . gettype($role));
        // Log::info("request user id -> " . $request->user()->id . ", role param -> " .$role);

        if($request->user()->id == $role) {
            return redirect('home');
        }
        //return redirect('home');
        return $next($request);
    }
}
