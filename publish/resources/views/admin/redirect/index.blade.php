@extends('fabric::admin.layouts.default')

@section('content')

    @include('fabric::admin.site.partials.tabs', ['tab' => 'redirects'])


    <div class="panel panel-default has-tabs">
        <div class="panel-body">
            <a href="{{ route('redirect.create') }}" class="btn btn-primary">Add Redirect</a>
        </div>

        <table class="table table-striped table-panel">
            <thead>
            <tr>
                <th>Old URL</th>
                <th>New URL</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach(site()->redirects as $redirect)
                    <tr>
                        <td>/{{ ltrim($redirect->old_url, '/') }}</td>
                        <td>{{ $redirect->new_url }}</td>
                        <td class="btn-column">
                            <a href="{{ route('redirect.edit', $redirect->uuid) }}" class="btn btn-default btn-sm">Edit</a>
                        </td>
                        <td class="btn-column">
                            {!! Form::open(['route' => 'redirect.destroy', 'method' => 'DELETE', 'role' => 'delete-redirect']) !!}
                            {!! Form::hidden('uuid', $redirect->uuid) !!}
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
        $(document).on('submit', '[role="delete-redirect"]', function (e) {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to delete this redirect?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection