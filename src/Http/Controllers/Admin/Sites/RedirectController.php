<?php

namespace Privateer\Fabric\Http\Controllers\Admin\Sites;

use Privateer\Fabric\Sites\Redirect;
use Illuminate\Http\Request;
use Privateer\Fabric\Http\Controllers\Controller;

class RedirectController extends Controller
{
    public function index()
    {
        return view('fabric::admin.redirect.index');
    }

    public function create()
    {
        return view('fabric::admin.redirect.create');
    }

    public function store(Request $request)
    {
        site()->redirects()->save(new Redirect($request->only(['old_url', 'new_url'])));

        flash()->success('Redirect created');

        return redirect()->route('redirect.index');
    }

    public function edit($uuid)
    {
        $redirect = Redirect::where('uuid', $uuid)->where('site_id', site('id'))->firstOrFail();

        return view('fabric::admin.redirect.edit', compact('redirect'));
    }

    public function update(Request $request, $uuid)
    {
        $redirect = Redirect::where('uuid', $uuid)->where('site_id', site('id'))->firstOrFail();

        $redirect->fill($request->only(['old_url', 'new_url']));

        $redirect->save();

        flash()->success('Redirect updated');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $redirect = Redirect::where('uuid', $request->get('uuid'))->where('site_id', site('id'))->firstOrFail();

        $redirect->delete();

        flash()->success('Redirect deleted');

        return redirect()->route('redirect.index');
    }

}
