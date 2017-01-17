<?php

namespace Privateer\Fabric\Http\Middleware;

use Closure;

class NullAuth
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
        return redirect('/');
    }
}
