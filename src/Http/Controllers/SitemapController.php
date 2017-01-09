<?php

namespace Privateer\Fabric\Http\Controllers;

use Illuminate\Http\Request;
use Watson\Sitemap\Facades\Sitemap;

class SitemapController extends Controller
{
    public function show()
    {
        // Homepage
        Sitemap::addTag(url('/'), null, 'daily', '0.8');

        // Pages
        foreach(site()->pages as $page)
        {
            if($page->id != site('homepage_id')) Sitemap::addTag(url($page->url), null, 'daily', '0.8');
        }

        return Sitemap::render();
    }
}
