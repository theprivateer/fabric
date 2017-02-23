@extends('fabric::admin.layouts.default')

@section('content')

    @include('fabric::admin.site.partials.tabs', ['tab' => 'edit'])

    {!! Form::model(site()) !!}
    <div class="panel panel-default has-tabs">
        <div class="panel-body">
            <!-- Name Form Input -->
            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <!-- Homepage_id Form Input -->
            <div class="form-group">
                {!! Form::label('homepage_id', 'Homepage:') !!}
                {!! Form::select('homepage_id', $pages, null, ['class' => 'form-control']) !!}
            </div>

            <!-- feed page Form Input -->
            <div class="form-group">
                {!! Form::label('feed_page_id', 'Feed Page:') !!}
                {!! Form::select('feed_page_id', $pages, null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="panel-footer">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Default SEO</h3>
        </div>

        <div class="panel-body">
            <!-- Seo_title Form Input -->
            <div class="form-group">
                {!! Form::label('meta[seo_title]', 'Page Title:') !!}
                {!! Form::text('meta[seo_title]', null, ['class' => 'form-control']) !!}
            </div>

            <!-- Seo_description Form Input -->
            <div class="form-group">
                {!! Form::label('meta[seo_description]', 'Meta Description:') !!}
                {!! Form::text('meta[seo_description]', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="panel-footer">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection