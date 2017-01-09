@extends('fabric::theme.layouts.default')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1 class="page-header">{{ $page->getTitle() }}</h1>

                {!! $page->getBody() !!}

                @php($articles = site()->publishedArticles()->paginate())
                @foreach($articles as $article)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3><a href="{{ url($article->prefixed_url) }}">{{ $article->getTitle() }}</a></h3>

                        {!! $article->getExcerpt() !!}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection