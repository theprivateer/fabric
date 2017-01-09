<?php

namespace Privateer\Fabric\Http\Controllers;

use Privateer\Fabric\Sites\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $page = Page::findOrFail(site('homepage_id'));

        return template($page->template, compact('page'));
    }

    public function show($path)
    {
        $page = Page::where('url', $path)->where('site_id', site('id'))->firstOrFail();

        if($page->id == site('homepage_id')) return redirect()->to('/');

        if ($page->template == '_raw') {
            return response($page->getExcerpt(false), 200, ['Content-Type' => 'text/plain']);
        }

        return template($page->template, compact('page'));
    }
}
