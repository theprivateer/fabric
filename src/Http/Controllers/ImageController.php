<?php

namespace Privateer\Fabric\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Glide\ServerFactory;

class ImageController extends Controller
{
    public function show(Request $request, $path)
    {
        ini_set('memory_limit','256M');

        $server = ServerFactory::create([
            'source' => Storage::getDriver(),
            'cache' => storage_path('app/.cache'), // cached files should ideally be stored locally
        ]);

        return $server->outputImage($path, $request->all());
    }
}
