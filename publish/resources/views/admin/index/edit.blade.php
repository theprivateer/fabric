@extends('fabric::admin.layouts.default')

@section('content')
    <div class="page-header clearfix" style="margin-top: 0;">
        <h1 class="pull-left" style="margin-top: 0;">Edit Index <small>{{ $index->name }}</small></h1>

        <a href="{{ route('fabric::index.create') }}" class="btn btn-default btn-lg pull-right">Create Index</a>
    </div>

    {!! Form::model($index) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <!-- Name Form Input -->
            <div class="form-group">
                {!! Form::label('name', 'Name:') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="panel-footer">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    <h2 class="page-header">Index Items</h2>

    <div class="row">
        <div class="col-md-5">
            <p>
                <button class="btn btn-default" role="external-link">Add an External Link</button>
            </p>

            @foreach($index->availableItems() as $key => $models)

            {!! Form::open(['role' => 'source-form', 'data-class' => $key, 'data-class-basename' => class_basename($key)]) !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Available {{ str_plural(class_basename($key)) }}</h3>
                </div>

                <table class="table table-striped table-panel">
                    <tbody>
                    @foreach($models as $model)
                        <tr id="row-{{ $model->uuid }}" data-name="{{ $model->name }}" data-uuid="{{ $model->uuid }}">
                            <td class="btn-column">
                                {!! Form::checkbox('item[]', $model->id, null, ['id' => 'model_' . $model->uuid]) !!}
                            </td>
                            <td><label for="model_{{ $model->uuid }}">{{ $model->name }}</label></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="panel-footer">
                    <button class="btn btn-default">Add To Index</button>
                </div>
            </div>
            {!! Form::close() !!}

            @endforeach
        </div>

        <div class="col-md-7">
            {!! Form::open() !!}
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Index Items</h3>
                </div>

                <table class="table table-striped table-panel table-sortable" id="item-table">
                    <tbody id="target-panel">
                        @foreach($index->items as $item)
                            @if($item->model)
                            <tr id="item-{{ $item->model->uuid }}">
                                <td class="sort-handle">
                                    <i class="icon-arrows"></i>
                                    {!! Form::hidden('items[' . $item->model->uuid . '][sort]', $item->sort, ['role' => 'sort-order']) !!}
                                    {!! Form::hidden('items[' . $item->model->uuid . '][model_type]', $item->model_type) !!}
                                    {!! Form::hidden('items[' . $item->model->uuid . '][model_id]', $item->model_id) !!}
                                </td>
                                <td class="btn-column text-muted"><small>{{ class_basename($item->model_type) }}</small></td>
                                <td>{{ $item->model->name }}</td>
                                <td class="btn-column">
                                    <button class="btn btn-default btn-sm" role="remove-item" data-uuid="{{ $item->model->uuid }}">Remove</button>
                                </td>
                            </tr>
                            @else
                            <tr id="item-{{ $item->uuid }}">
                                <td class="sort-handle">
                                    <i class="icon-arrows"></i>
                                    {!! Form::hidden('items[' . $item->uuid . '][sort]', $item->sort, ['role' => 'sort-order']) !!}
                                </td>
                                <td class="btn-column text-muted"><small>External</small></td>
                                <td>
                                    <input name="items[{{ $item->uuid }}][label]" type="text" class="form-control" placeholder="Label" style="margin-bottom: 5px;" value="{{ $item->label }}">
                                    <input name="items[{{ $item->uuid }}][external_link]" type="text" class="form-control" placeholder="URL" style="margin-bottom: 5px;" value="{{ $item->external_link }}">
                                    <input name="items[{{ $item->uuid }}][custom]" type="text" class="form-control" placeholder="Custom Field" value="{{ $item->custom }}">
                                </td>
                                <td class="btn-column">
                                    <button class="btn btn-default btn-sm" role="remove-item" data-uuid="{{ $item->uuid }}">Remove</button>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <div class="panel-footer">
                    {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="/vendor/fabric/js/vendor/jquery.sortable.min.js"></script>
    <script src="/vendor/fabric/js/vendor/handlebars.js"></script>

    <script>
        $('[role="source-form"]').on('submit', function(e) {
           e.preventDefault();

            var theForm = this;

            $('tbody tr', theForm).each(function()
            {
                if($('[type="checkbox"]', this).is(':checked'))
                {
                    var source   = $("#item-row").html();
                    var template = Handlebars.compile(source);
                    var html    = template({
                        uuid: $(this).data('uuid'),
                        name: $(this).data('name'),
                        class_id: $('[type="checkbox"]', this).val(),
                        class: $(theForm).data('class'),
                        class_basename: $(theForm).data('class-basename')

                    });

                    $('#target-panel').append(html);

                    $(this).remove();

                }
            });

            initSorting();
            doSorting();
        });

        $('[role="external-link"]').on('click', function(e) {
            e.preventDefault();

            var source   = $("#external-link-row").html();
            var template = Handlebars.compile(source);
            var html    = template({
                uuid: generateUUID(),
            });

            $('#target-panel').append(html);

            initSorting();
            doSorting();
        });

        function generateUUID() {
            var d = new Date().getTime();
            var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = (d + Math.random()*16)%16 | 0;
                d = Math.floor(d/16);
                return (c=='x' ? r : (r&0x3|0x8)).toString(16);
            });
            return uuid;
        }


        function initSorting()
        {
            if($('#item-table').length) {
                $('#item-table').sortable({
                    group: 'items',
                    containerSelector: 'table',
                    itemPath: '> tbody',
                    itemSelector: 'tr',
                    placeholder: '<tr class="placeholder"/>',
                    handle: 'td.sort-handle',
                    onDrop: function ($item, container, _super) {
                        $item.removeClass(container.group.options.draggedClass).removeAttr('style');
                        $('body').removeClass(container.group.options.bodyClass);

                        doSorting();

                        _super($item, container);
                    }
                });
            }
        }

        function doSorting()
        {
            var i = 0;
            $('#item-table tbody tr').each(function() {
                $('[role="sort-order"]', this).val(i);

                i++;
            });
        }

        $(document).on('click', '[role="remove-item"]', function(e) {
            e.preventDefault();

            var target = $('#item-' + $(this).data('uuid'));

            $(target).remove();

            initSorting();
            doSorting();
        });

        initSorting();

    </script>

    @include('fabric::admin.index.partials.item-row')
    @include('fabric::admin.index.partials.external-link-row')
@endsection