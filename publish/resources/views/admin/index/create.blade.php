@extends('fabric::admin.layouts.default')

@section('content')
    <div class="page-header clearfix" style="margin-top: 0;">
        <h1 class="pull-left" style="margin-top: 0;">Create Index</h1>

        <a href="{{ route('fabric::index.index') }}" class="btn btn-default btn-lg pull-right">Cancel</a>
    </div>

    {!! Form::open() !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <!-- Name Form Input -->
            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="panel-footer">
            {!! Form::submit('Create Index', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection