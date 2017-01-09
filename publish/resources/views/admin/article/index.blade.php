@extends('fabric::admin.layouts.default')

@section('content')
    <div class="page-header clearfix" style="margin-top: 0;">
        <h1 class="pull-left" style="margin-top: 0;">Articles</h1>

        <a href="{{ route('article.create') }}" class="btn btn-default btn-lg pull-right">Create Article</a>
    </div>

    <div class="panel panel-default">

        <table class="table table-striped table-panel">
            <thead>
                <tr>
                    <th>Article Name</th>
                    <th>URL</th>
                    <th>Publish At</th>
                    <th class="btn-column"></th>
                    <th class="btn-column"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>
                            {!! link_to_route('article.edit', $article->name, $article->uuid) !!}
                            @if($article->draft)
                                <span class="label label-info">DRAFT</span>
                            @endif
                        </td>
                        <td><a href="{{ url( $article->prefixed_url ) }}" target="_blank">{{ $article->prefixed_url }}</a></td>
                        <td>
                            {{ (! empty($article->publish_at)) ? $article->publish_at->format('j F Y') : null }}
                        </td>
                        <td>
                            <a href="{{ route('article.edit', $article->uuid) }}" class="btn btn-default btn-sm">Edit</a>
                        </td>
                        <td>
                            {!! Form::open(['route' => 'article.destroy', 'method' => 'DELETE', 'role' => 'delete-article']) !!}
                            {!! Form::hidden('uuid', $article->uuid) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-default btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="/vendor/fabric/js/vendor/bootbox.js"></script>

    <script>
        $(document).on('submit', '[role="delete-article"]', function (e) {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to delete this article?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection