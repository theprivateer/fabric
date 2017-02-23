<?php

namespace Privateer\Fabric\Http\Controllers\Admin\Articles;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Privateer\Fabric\Articles\Article;
use Privateer\Fabric\Http\Controllers\Controller;

class ArticleController
{
    public function index()
    {
        $articles = Article::latest()->paginate(25);

        return view('fabric::admin.article.index', compact('articles'));
    }

    public function create()
    {
        return view('fabric::admin.article.create');
    }

    public function store(Request $request)
    {
        $article = Article::createForSite($request->all(), site('id'), Auth::user()->id);

        flash()->success('Article created');

        return redirect()->route('fabric::article.index');
    }

    public function edit($uuid)
    {
        $article = Article::where('uuid', $uuid)->where('site_id', site('id'))->firstOrFail();

        return view('fabric::admin.article.edit', compact('article'));
    }

    public function update(Request $request, $uuid)
    {
        $article = Article::where('uuid', $uuid)->where('site_id', site('id'))->firstOrFail();

        $article->updateWithContent($request->all());

        flash()->success('Article updated');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $article = Article::where('uuid', $request->get('uuid'))->where('site_id', site('id'))->firstOrFail();

        $article->remove();

        flash()->success('Article deleted');

        return redirect()->route('fabric::article.index');
    }
}