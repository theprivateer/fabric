<?php

namespace Privateer\Fabric\Http\Controllers\Admin\Pages;

use Illuminate\Support\Facades\File;
use Privateer\Fabric\Sites\Page;
use Illuminate\Http\Request;
use Privateer\Fabric\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        return view('fabric::admin.page.index');
    }

    private function getTemplates()
    {
        try
        {
            // List available templates
            $templates = [];

            if (site('theme', 'default') != 'default') {
                $dir = File::allFiles(public_path('themes/' . site('theme') . '/views'));
            } else {
                $dir = File::allFiles(base_path('vendor/theprivateer/fabric/publish/resources/views/theme'));
            }


            foreach ($dir as $file) {
                if (strpos($file->getRelativePathname(), '.blade.php') !== false && strpos($file->getRelativePathname(), '_') !== 0) {
                    $shortname = str_replace('.blade.php', '', $file->getRelativePathname());
                    $templates[$shortname] = ucwords($shortname);
                }
            }

            $templates['_raw'] = 'Raw (outputs page excerpt only)';

            return $templates;

        } catch(\Exception $e)
        {
            return null;
        }
    }

    public function create()
    {
        $templates = $this->getTemplates();

        return view('fabric::admin.page.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $page = Page::createForSite($request->all(), site('id'));

        flash()->success('Page created');

        return redirect()->route('page.index');
    }

    public function edit($uuid)
    {
        $page = Page::where('uuid', $uuid)->where('site_id', site('id'))->firstOrFail();

        $templates = $this->getTemplates();

        return view('fabric::admin.page.edit', compact('page', 'templates'));
    }

    public function update(Request $request, $uuid)
    {
        $page = Page::where('uuid', $uuid)->where('site_id', site('id'))->firstOrFail();

        $page->updateWithContent($request->all());

        flash()->success('Page updated');

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $page = Page::where('uuid', $request->get('uuid'))->where('site_id', site('id'))->firstOrFail();

        $page->remove();

        flash()->success('Page deleted');

        return redirect()->route('page.index');
    }
}
