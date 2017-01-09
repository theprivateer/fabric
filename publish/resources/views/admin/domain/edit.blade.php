@extends('fabric::admin.layouts.default')

@section('content')

    @include('fabric::admin.site.partials.tabs', ['tab' => 'domains'])


    <div class="panel panel-default has-tabs">
        {!! Form::model($domain) !!}
        <div class="panel-body">
            <!-- Old_url Form Input -->
            <div class="form-group">
                {!! Form::label('domain', 'Domain Name:') !!}
                {!! Form::text('domain', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="panel-footer">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}


    </div>
@endsection