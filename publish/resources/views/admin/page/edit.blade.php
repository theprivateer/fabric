@extends('fabric::admin.layouts.default')

@section('content')

    <div class="page-header clearfix" style="margin-top: 0;">
        <h1 class="pull-left" style="margin-top: 0;">Edit Page</h1>

        <a href="{{ route('fabric::page.create') }}" class="btn btn-default btn-lg pull-right">Create Page</a>
    </div>

    {!! Form::model($page) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <!-- Name Form Input -->
            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            @if( ! empty($templates))
            <!-- Template Form Input -->
            <div class="form-group">
                {!! Form::label('template', 'Template:') !!}
                {!! Form::select('template', $templates, null, ['class' => 'form-control']) !!}
            </div>
            @endif
        </div>

        <div class="panel-footer">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Page Content</h3>
        </div>

        <div class="panel-body">
            <!-- Title Form Input -->
            <div class="form-group">
                {!! Form::label('content[title]', 'Title:') !!}
                {!! Form::text('content[title]', null, ['class' => 'form-control']) !!}
            </div>

            <!-- Excerpt Form Input -->
            <div class="form-group">
                {!! Form::label('content[excerpt]', 'Excerpt:') !!}
                {!! Form::textarea('content[excerpt]', null, ['class' => 'form-control', 'rows' => 2]) !!}
            </div>

            <!-- Body Form Input -->
            <div class="form-group">
                {!! Form::label('content[body]', 'Body:') !!}
                {!! Form::textarea('content[body]', null, ['class' => 'form-control', 'rows' => 15, 'role' => 'editor']) !!}
            </div>
        </div>

        <div class="panel-footer">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Featured Image</h3>
        </div>

        <div class="panel-body">
            @include('fabric::admin.layouts.partials.image-upload', ['model' => $page, 'field' => 'content[image_id]'])
        </div>

        <div class="panel-footer">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Page SEO</h3>
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

    @include('fabric::admin.layouts.partials.media-modal')

@endsection

@section('scripts')
    @parent

    <script src="/vendor/fabric/js/vendor/tinymce/tinymce.min.js"></script>

    <script>
        function tinymceInit()
        {
            tinymce.init({
                selector: 'textarea[role="editor"]',
                menubar : false,
                content_css : '/vendor/fabric/css/editor.css',
                statusbar : false,
                plugins: "link code paste",
                toolbar: "bold italic styleselect | bullist numlist | link code | fabricimg",
                valid_elements : '+*[*]',
                convert_urls: false,
                style_formats: [
                    {title: "Header 1", format: "h1"},
                    {title: "Header 2", format: "h2"},
                    {title: "Header 3", format: "h3"},
                    {title: "Header 4", format: "h4"},
                    {title: "Header 5", format: "h5"},
                    {title: "Header 6", format: "h6"},
                    {title: "Blockquote", format: "blockquote"}
                ],
                setup : function(ed) {
                    // Add a custom button
                    ed.addButton('fabricimg', {
                        title : 'Insert Image',
                        image: '/vendor/fabric/img/tinymce-photo-icon.png',
                        onclick : function() {
                            $('#media-browser').modal('show');
                            targetEditor = ed;
                        }
                    });
                }
            });
        }

        tinymceInit();
    </script>
@endsection
