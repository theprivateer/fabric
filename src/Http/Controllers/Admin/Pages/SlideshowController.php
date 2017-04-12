<?php

namespace Privateer\Fabric\Http\Controllers\Admin\Pages;

use Illuminate\Support\Facades\File;
use Privateer\Fabric\Sites\Page;
use Illuminate\Http\Request;
use Privateer\Fabric\Http\Controllers\Controller;

class SlideshowController extends Controller
{
    public function edit($uuid)
    {
        $page = Page::findByUuid($uuid);

        return view('fabric::admin.page.slideshow', compact('page'));
    }
}
