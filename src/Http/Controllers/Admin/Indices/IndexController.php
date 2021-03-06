<?php

namespace Privateer\Fabric\Http\Controllers\Admin\Indices;

use Privateer\Fabric\Sites\Navigation\Index;
use Privateer\Fabric\Sites\Navigation\Item;
use Illuminate\Http\Request;
use Privateer\Fabric\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('fabric::admin.index.index');
    }

    public function create()
    {
        return view('fabric::admin.index.create');
    }

    public function store(Request $request)
    {
        $index = new Index($request->all());

        site()->indices()->save($index);

        flash()->success('Index created');

        return redirect()->route('fabric::index.edit', $index->uuid);
    }

    public function edit($uuid)
    {
        $index = Index::where('uuid', $uuid)->where('site_id', site('id'))->firstOrFail();

        return view('fabric::admin.index.edit', compact('index'));
    }

    public function update(Request $request, $uuid)
    {
        $index = Index::where('uuid', $uuid)->where('site_id', site('id'))->firstOrFail();

        $index->fill($request->except('items'));

        $index->save();

        $index->items()->delete();

        if($request->has('items'))
        {
            foreach($request->get('items') as $item)
            {
                $item['model_type'] = ( ! empty($item['model_type'])) ? $item['model_type'] : '';
                $item['model_id'] = ( ! empty($item['model_id'])) ? $item['model_id'] : 0;

                $index->items()->save(new Item($item));
            }
        }

        flash()->success('Index updated');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $index = Index::where('uuid', $request->get('uuid'))->where('site_id', site('id'))->firstOrFail();

        $index->delete();

        flash()->success('Index deleted');

        return redirect()->route('fabric::index.index');
    }
}
