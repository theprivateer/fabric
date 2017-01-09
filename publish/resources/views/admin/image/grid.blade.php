<div class="row">
    @foreach($images as $image)
        <div class="col-sm-2 col-xs-3">
            <a href="#" class="thumbnail" role="thumbnail-btn" data-id="{{ $image->id }}" data-path="{!! $image->getPath(config('fabric.preview-image-parameters')) !!}">
                <div class="transparent-backdrop">

                    {!! $image->getTag(['w' => '200', 'h' => 200, 'fit' => 'crop'], ['class' => 'img-responsive']) !!}
                </div>
            </a>
        </div>
    @endforeach
</div>

{!! $images->render() !!}