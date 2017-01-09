<?php

namespace Privateer\Fabric\Services\MissingPageRedirector;

use Privateer\Fabric\Sites\Redirect;
use Spatie\MissingPageRedirector\Redirector\Redirector;
use Symfony\Component\HttpFoundation\Request;

class DatabaseRedirector implements Redirector
{

    public function getRedirectsFor(Request $request): array
    {
        return Redirect::where('site_id', site('id'))->get()->flatMap(function($redirect) {
            return [$redirect->old_url => $redirect->new_url];
        })->toArray();
    }
}