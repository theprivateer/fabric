@php($fieldHash = str_random())
<div class="image-preview" data-toggle="modal" data-target="#media-browser" data-target-field="{{ $field }}" id="{{ $fieldHash }}" style="width: 300px; height: 300px;">
    <i class="fa fa-cloud-upload fa-fw upload-icon"></i>
    @if( ! empty($model))
        {!! $model->featuredImage(config('fabric.preview-image-parameters'), ['class' => 'img-responsive content-image']) !!}

        {!! Form::hidden($field, $model->featuredImageId()) !!}
    @else
        {!! Form::hidden($field) !!}
    @endif
</div>