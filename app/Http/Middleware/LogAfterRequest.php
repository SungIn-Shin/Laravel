<?php

namespace App\Http\Middleware;

use Closure;
use App\Log_request;

class LogAfterRequest
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
        $response = $next($request);

        $this->log($request);

        return $response;
    }

    protected function log($request)
    {
        $logrequest = new Log_request();
        $logrequset = $logrequest->store($request);
    }
}
