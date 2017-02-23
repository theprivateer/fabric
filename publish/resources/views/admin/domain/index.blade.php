@extends('fabric::admin.layouts.default')

@section('content')

    @include('fabric::admin.site.partials.tabs', ['tab' => 'domains'])

    <div class="panel panel-default has-tabs">
        <div class="panel-body">
            <a href="{{ route('fabric::domain.create') }}" class="btn btn-primary">Add Domain</a>
        </div>

        <table class="table table-striped table-panel">
            <tbody>
                @foreach(site()->domains as $domain)
                    <tr>
                        <td>{{ $domain->domain }}</td>
                        @if( ! $domain->locked)
                        <td class="btn-column">
                            <a href="{{ route('fabric::domain.edit', $domain->uuid) }}" class="btn btn-default btn-sm">Edit</a>
                        </td>
                        <td class="btn-column">
                            {!! Form::open(['route' => 'fabric::domain.destroy', 'method' => 'DELETE', 'role' => 'delete-domain']) !!}
                            {!! Form::hidden('uuid', $domain->uuid) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-default btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        @else
                        <td colspan="2"></td>
                        @endif
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
        $(document).on('submit', '[role="delete-domain"]', function (e) {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to delete this domain?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection