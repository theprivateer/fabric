<?php

namespace Privateer\Fabric\Http\Controllers;

use Privateer\Fabric\Articles\Article;
use Privateer\Fabric\Sites\Page;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $page = site('feed');

        return template('feed', compact('page'));
    }

    public function show($path)
    {
        $page = Article::where('url', $path)->where('site_id', site('id'))->firstOrFail();

        return template('article', compact('page'));
    }
}
