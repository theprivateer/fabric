<?php

namespace Privateer\Fabric\Http\Controllers\Admin\Uploads;

use Privateer\Fabric\Uploads\Image;
use Illuminate\Http\Request;
use Privateer\Fabric\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use View;
use Webpatser\Uuid\Uuid;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        if ($request->file('file')->isValid()) {

            $upload = $request->file('file');

            $image = new Image;

            /*
             * This approach is problematic as it does not
             * pass the mime-type to S3 buckets:
             *
             * $image->file_name = $upload->store('uploads/' . site('uuid');
             */

            $image->file_name = $this->store_upload($upload, config('fabric.upload-prefix') . '/' . site('uuid') . '/' . date('Ymd'));
            $image->original_name = $upload->getClientOriginalName();
            $image->file_type = $upload->getClientMimeType();

            site()->images()->save($image);

            if($request->has('preview_parameters'))
            {
                parse_str($request->get('preview_parameters'), $parameters);
                $image->preview = $image->getPath($parameters);
            }

            return $image;
        }
    }

    /**
     * Sets the correct Content Type when uploading to S3
     */
    private function store_upload($upload, $path = '')
    {
        $file_name = $path . '/' . Uuid::generate(4) . '.' . $upload->getClientOriginalExtension();

        $stream = fopen($upload->getRealPath(), 'r+');

        Storage::getDriver()->put(
            $file_name,
            $stream,
            [
                'ContentType' => $upload->getClientMimeType()
            ]
        );

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $file_name;
    }

    public function grid()
    {
        $images = Image::where('site_id', site('id'))->latest()->paginate(18);

        return response()->json(View::make('fabric::admin.image.grid', compact('images'))->render());
    }

    public function generateTag(Request $request)
    {
        if($id = $request->get('id'))
        {
            $image = Image::findOrFail($id);

            $params = [];

            if($w = $request->get('width')) $params['w'] = $w;
            if($h = $request->get('height')) $params['h'] = $h;

            $params['fit'] = $request->get('fit', 'fill');

            $additional = parse_str($request->get('additional'));

            if( ! empty($additional)) $params = array_merge($additional, $params);

            // do something with the additional fields...
            return $image->getTag($params, ['class' => 'img-responsive']);
        }
    }

}
