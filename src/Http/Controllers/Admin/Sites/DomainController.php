<?php

namespace Privateer\Fabric\Http\Controllers\Admin\Sites;

use Illuminate\Http\Request;
use Privateer\Fabric\Http\Controllers\Controller;
use Privateer\Fabric\Sites\Domain;

class DomainController extends Controller
{
    public function index()
    {
        return view('fabric::admin.domain.index');
    }

    public function create()
    {
        return view('fabric::admin.domain.create');
    }

    public function store(Request $request)
    {
        site()->domains()->save(new Domain($request->only(['domain'])));

        flash()->success('Domain added');

        return redirect()->route('domain.index');
    }


    public function edit($uuid)
    {
        $domain = Domain::where('uuid', $uuid)->where('site_id', site('id'))->firstOrFail();

        return view('fabric::admin.domain.edit', compact('domain'));
    }

    public function update(Request $request, $uuid)
    {
        $domain = Domain::where('uuid', $uuid)->where('site_id', site('id'))->firstOrFail();

        $domain->fill($request->only(['domain']));

        $domain->save();

        flash()->success('Domain updated');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $domain = Domain::where('uuid', $request->get('uuid'))->where('site_id', site('id'))->where('locked', false)->firstOrFail();

        $domain->delete();

        flash()->success('Domain deleted');

        return redirect()->route('domain.index');
    }
}
