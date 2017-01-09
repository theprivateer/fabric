<?php

namespace Privateer\Fabric\Http\Controllers\Admin\Sites;

use Illuminate\Http\Request;
use Privateer\Fabric\Http\Controllers\Controller;

class SiteController extends Controller
{
    public function edit()
    {
        $pages = site()->pages()->pluck('name', 'id')->all();

        return view('fabric::admin.site.edit', compact('pages'));
    }

    public function update(Request $request)
    {
        site()->updateWithMeta($request->all());

        flash()->success('Site updated');

        return redirect()->back();
    }
}
