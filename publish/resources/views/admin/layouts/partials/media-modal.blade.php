<div class="modal fade" tabindex="-1" role="dialog" id="media-browser">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Media Browser</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs media-modal-tabs" role="tablist" id="media-modal-tabs">
                    <li role="presentation" class="active"><a href="#upload-pane" aria-controls="upload-pane" role="tab" data-toggle="tab">Upload Image</a></li>
                    <li role="presentation"><a href="#library-pane" aria-controls="library-pane" role="tab" data-toggle="tab">Choose from Library</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="upload-pane">

                        <div class="featured-image-uploader" role="media-dropzone">
                            <div class="dropzone image-clickable" id="image-clickable">
                                <div id="image-preview" class="dropzone-previews"></div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="library-pane">
                        <div id="grid"></div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-lg btn-primary disabled" role="insert-media-btn">Use Image</button>

                <div class="row" id="editor-insert-controls" style="display: none;">
                    <div class="col-md-3">
                        <a class="thumbnail">
                            <img id="insert-preview">
                        </a>

                    </div>

                    <div class="col-md-9 text-left">
                        {!! Form::open(['id' => 'editor-insert-form']) !!}
                        <input type="hidden" name="id">

                        <!-- Foo Form Input -->
                        <div class="form-group">
                            {!! Form::label('width', 'Width:') !!}
                            <div class="input-group">
                                {!! Form::text('width', null, ['class' => 'form-control']) !!}
                                <span class="input-group-addon">px</span>
                            </div>
                        </div>

                        <!-- Height Form Input -->
                        <div class="form-group">
                            {!! Form::label('height', 'Height:') !!}
                            <div class="input-group">
                                {!! Form::text('height', null, ['class' => 'form-control']) !!}
                                <span class="input-group-addon">px</span>
                            </div>
                        </div>

                        <!-- Additional Form Input -->
                        <div class="form-group">
                            {!! Form::label('additional', 'Additional Parameters:') !!}
                            {!! Form::text('additional', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Submit field -->
                        <div class="form-group">
                            {!! Form::submit('Insert Image', ['class' => 'btn btn-primary btn-lg']) !!}
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@section('head')
    @parent
    <link rel="stylesheet" href="/vendor/fabric/js/vendor/dropzone/dropzone.css">

@endsection

@section('scripts')
    @parent

    <script src="/vendor/fabric/js/vendor/dropzone/dropzone.js"></script>


    <script>
        var insertBtn = $('[role="insert-media-btn"]');
        var targetField;
        var targetId;
        var targetContainer;
        var targetEditor;

        $('#media-browser').on('show.bs.modal', function (e) {
            var btn = $(e.relatedTarget) // Button that triggered the modal

            if(btn.data('target-field') != undefined)
            {
                targetField = btn.data('target-field') // Extract info from data-* attributes

                if(btn.data('target-id') != undefined)
                {
                    targetContainer = $('#' + btn.data('target-id'));
                } else
                {
                    targetContainer = btn;
                }
            }

        });

        $('#media-browser').on('hidden.bs.modal', function (e) {
            // Reset all the things
            $('.content-image', '[role="media-dropzone"]').remove();

            insertBtn.show();
            insertBtn.data('id', '');
            insertBtn.data('path', '');
            insertBtn.addClass('disabled');

            $('#media-browser .modal-body').show();
            $('#media-browser #editor-insert-controls').hide();
            $('#editor-insert-form')[0].reset();

            targetField = undefined;
            targetId = undefined;
            targetContainer = undefined;
            targetEditor = undefined;

        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

            var href = String(e.target);
            var hash = href.substring(href.indexOf('#'));

            if(hash == '#library-pane')
            {
                getLibrary('{{ route('image.grid') }}');
            }
        })

        function getLibrary(path)
        {
            $.ajax({
                url: path,
                dataType: 'json',
            }).done(function (data) {
                $('#library-pane #grid').html(data);
            }).fail(function () {
                alert('Library could not be loaded.');
            });
        }

        $(document).ready(function() {
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                getLibrary($(this).attr('href'));
            });

            $(document).on('click', '[role="thumbnail-btn"]', function (e) {
                console.log($(this).data('id'));
                e.preventDefault();

                var theBtn = this;


                if($(theBtn).hasClass('selected'))
                {
                    $(theBtn).removeClass('selected');

                    updateInsertBtn()
                } else
                {
                    // remove the selected class from all of the others
                    $('[role="thumbnail-btn"]').each(function() {
                        $(this).removeClass('selected');
                    });

                    $(theBtn).addClass('selected');

                    updateInsertBtn($(theBtn).data('id'), $(theBtn).data('path'));
                }

            });
        });

        function updateInsertBtn(id, path)
        {
            insertBtn.data('id', id);
            insertBtn.data('path', path);

            if(id != undefined)
            {
                insertBtn.removeClass('disabled');
            } else
            {
                insertBtn.addClass('disabled');
            }
        }

        $('[role="insert-media-btn"]').on('click', function (e) {
            e.preventDefault();

            // if it's an editor window...
            if(targetEditor != undefined)
            {
//                $(this).addClass('disabled');

                $(this).hide();

                console.log($(this).data('id'));

                // Bring in the detailed insert dialogue
                $('#editor-insert-form [name="id"]').val( $(this).data('id') );
                $('#insert-preview').attr('src', $(this).data('path'));
                $('#media-browser .modal-body').slideToggle();
                $('#media-browser #editor-insert-controls').slideToggle();

            } else
            {
                $('[name="' + targetField + '"]').val( $(this).data('id') );

                if( ! $('.content-image', targetContainer).length)
                {
                    $(targetContainer).append('<img class="img-responsive content-image" />');

                }

                $('.content-image', targetContainer).attr('src', $(this).data('path'));

                $('#media-browser').modal('hide');
            }
        });

        $('#editor-insert-form').on('submit', function(e)
        {
            e.preventDefault();

            $.post("{{ route('image.tag') }}"
                , $(this).serialize() )
                .done(function( data ) {

                    targetEditor.focus();
                    targetEditor.selection.setContent(data);

                    $('#media-browser').modal('hide');
                });
        });


        Dropzone.autoDiscover = false;

        $('[role="media-dropzone"]').each(function () {

            if (this.dropzone == undefined) {
                var background = $(this);
                var clickable = $('.image-clickable', this);
                var previews = $('.dropzone-previews', this);

                if( ! $('.content-image', this).length)
                {
                    $(this).append('<img class="img-responsive content-image" />');
                }

                var image = $('.content-image', this);

                $(this).dropzone({
                    url: '{{ route('image.create') }}',
                    addRemoveLinks: true,
                    acceptedFiles: 'image/*',
                    maxFiles: 1,
                    maxFilesize: {{ env('UPLOAD_LIMIT', 10) }},
                    parallelUploads: 1,
                    previewsContainer: previews[0],
                    clickable: clickable[0],
                    init: function () {
                        this.on('addedfile', function(file) {
                            image.css('opacity', 0.3);
                        });

                        this.on('sending', function (file, xhr, formData) {
                            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                            formData.append('preview_parameters', '{{ http_build_query(config('fabric.preview-image-parameters')) }}');
                        });

                        this.on("success", function (file, responseText) {
                            console.log(responseText);

                            image.attr('src', responseText.preview).css('opacity', 1);

                            updateInsertBtn(String(responseText.id), responseText.preview);

                            this.removeFile(file);
                        });
                    }
                });
            }
        });
    </script>
@endsection