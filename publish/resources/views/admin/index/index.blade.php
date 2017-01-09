@extends('fabric::admin.layouts.default')

@section('content')
    <div class="page-header clearfix" style="margin-top: 0;">
        <h1 class="pull-left" style="margin-top: 0;">Indices</h1>

        <a href="{{ route('index.create') }}" class="btn btn-default btn-lg pull-right">Create Index</a>
    </div>

    <div class="panel panel-default">

        <table class="table table-striped table-panel">
            <thead>
                <tr>
                    <th>Index Name</th>
                    <th>Short Name</th>
                    <th class="btn-column"></th>
                    <th class="btn-column"></th>
                </tr>
            </thead>
            <tbody>
                @foreach(site()->indices as $index)
                    <tr>
                        <td>{{ $index->name }}</td>
                        <td>{{ $index->short_name }}</td>
                        <td>
                            <a href="{{ route('index.edit', $index->uuid) }}" class="btn btn-default btn-sm">Edit</a>
                        </td>
                        <td>
                            {!! Form::open(['route' => 'index.destroy', 'method' => 'DELETE', 'role' => 'delete-index']) !!}
                            {!! Form::hidden('uuid', $index->uuid) !!}
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
        $(document).on('submit', '[role="delete-index"]', function (e) {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to delete this index?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection