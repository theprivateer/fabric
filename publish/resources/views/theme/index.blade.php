@extends('fabric::theme.layouts.default')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                {!! $page->getTitle('<h1 class="page-header">', '</h1>', 'Welcome!') !!}

                <p>This is the homepage.</p>
            </div>
        </div>
    </div>

@endsection