@extends('fabric::admin.layouts.default')

@section('content')
    <div class="page-header clearfix" style="margin-top: 0;">
        <h1 class="pull-left" style="margin-top: 0;">Pages</h1>

        <a href="{{ route('fabric::page.create') }}" class="btn btn-default btn-lg pull-right">Create Page</a>
    </div>

    <div class="panel panel-default">

        <table class="table table-striped table-panel">
            <thead>
                <tr>
                    <th>Page Name</th>
                    <th>URL</th>
                    <th class="btn-column"></th>
                    <th class="btn-column"></th>
                </tr>
            </thead>
            <tbody>
                @foreach(site()->pages as $page)
                    <tr>
                        <td>
                            {!! link_to_route('fabric::page.edit', $page->name, $page->uuid) !!}
                        </td>
                        <td><a href="{{ url( $page->url ) }}" target="_blank">{{ $page->url }}</a></td>
                        <td>
                            <a href="{{ route('fabric::page.edit', $page->uuid) }}" class="btn btn-default btn-sm">Edit</a>
                        </td>
                        <td>
                            {!! Form::open(['route' => 'fabric::page.destroy', 'method' => 'DELETE', 'role' => 'delete-page']) !!}
                            {!! Form::hidden('uuid', $page->uuid) !!}
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
        $(document).on('submit', '[role="delete-page"]', function (e) {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to delete this page?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection