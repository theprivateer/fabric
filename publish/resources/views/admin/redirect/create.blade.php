@extends('fabric::admin.layouts.default')

@section('content')

    @include('fabric::admin.site.partials.tabs', ['tab' => 'redirects'])


    <div class="panel panel-default has-tabs">
        {!! Form::open() !!}
        <div class="panel-body">
            <!-- Old_url Form Input -->
            <div class="form-group">
                {!! Form::label('old_url', 'Old URL:') !!}
                {!! Form::text('old_url', null, ['class' => 'form-control']) !!}
            </div>

            <!-- New_url Form Input -->
            <div class="form-group">
                {!! Form::label('new_url', 'New URL:') !!}
                {!! Form::text('new_url', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="panel-footer">
            {!! Form::submit('Create Redirect', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}


    </div>
@endsection