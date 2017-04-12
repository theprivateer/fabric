<?php

if( ! function_exists('site'))
{
    function site($key = null, $default = null)
    {
        try
        {
            $site = app('site');
        } catch( \Exception $e)
        {

            if( ! config('fabric.allow-null-site'))
            {
                $class = config('fabric.site');

                $site = $class::first();

                // Set it for future calls
                \Illuminate\Support\Facades\App::singleton('site', $site);
            } else
            {
                return null;
            }
        }

        if ( ! is_null($key)) {
            return ( ! empty($site->$key)) ? $site->$key : $default;
        }

        return $site;
    }
}

if( ! function_exists('template'))
{
    function template($template = null, $data = [])
    {
        if(empty($template)) $template = 'page';

        if(view()->exists($template))
        {
            return view($template, $data);
        } elseif(view()->exists('fabric::theme.' . $template))
        {
            return view('fabric::theme.' . $template, $data);
        }

        $template = (view()->exists('page')) ? 'page' : 'fabric::theme.page';

        return view($template, $data);
    }
}

if( ! function_exists('theme'))
{
    function theme($path)
    {
        if ( ! empty(site('theme')) && site('theme') != 'default') {
            return url('/themes/' . site('theme') . '/' . $path);
        }

        return url('/vendor/fabric/theme/' . $path);
    }
}



if( ! function_exists('nav'))
{
    function nav($short_name, $class = null)
    {
        try
        {
            $index = \Privateer\Fabric\Sites\Navigation\Index::where('short_name', $short_name)->where('site_id', site('id'))->firstOrFail();

            $nav = \Spatie\Menu\Laravel\Menu::new();

            if($class) $nav->addClass($class);

            foreach($index->items as $item)
            {
                if($item->model)
                {
                    if(class_basename($item->model_type) == 'Index')
                    {
                        $nav->submenu(
                            \Spatie\Menu\Laravel\Link::to('#', $item->model->name . ' <span class="caret"></span>')
                                ->addClass('dropdown-toggle')
                                ->setAttributes(['data-toggle' => 'dropdown', 'role' => 'button']),
                            nav($item->model->short_name, 'dropdown-menu')
                        );
                    } else
                    {
                        $nav->add(\Spatie\Menu\Laravel\Link::to(url($item->model->url), $item->model->name));
                    }
                } else
                {
                    $nav->add(\Spatie\Menu\Laravel\Link::to($item->external_link, $item->label));
                }
            }

            return $nav;

        } catch( \Exception $e)
        {

        }
    }
}

if( ! function_exists('get_nav'))
{
    function get_nav($short_name)
    {
        try
        {
            $index = \Privateer\Fabric\Sites\Navigation\Index::where('short_name', $short_name)->where('site_id', site('id'))->firstOrFail();

            return $index;

        } catch( \Exception $e)
        {
            return new \Privateer\Fabric\Sites\Navigation\Index();
        }
    }
}
