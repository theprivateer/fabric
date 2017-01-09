<?php

namespace Privateer\Fabric\Http\Middleware;

use Illuminate\Support\Facades\View;
use Privateer\Fabric\Sites\Domain;
use Privateer\Fabric\Sites\Site;
use Closure;
use Illuminate\Support\Facades\App;

class GetSite
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
        App::singleton('site', function() use ($request) {

            $class = config('fabric.site');

            try
            {
                $domain = Domain::where('domain', $request->getHost())->firstOrFail();

                return $class::with('feed')->findOrFail($domain->site_id);

            } catch(\Exception $e)
            {
                return $class::with('feed')->first();
            }
        });

        /*
         * Register the theme folder
         */
        if ( ! empty(site('theme')) && site('theme') != 'default') {
            View::addLocation(public_path('themes/' . site('theme') . '/views'));
        }

        return $next($request);
    }
}
