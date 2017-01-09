<?php

namespace Privateer\Fabric\Console\Commands;

use Illuminate\Console\Command;
use Privateer\Fabric\Sites\Content;
use Privateer\Fabric\Sites\Domain;
use Privateer\Fabric\Sites\Page;
use Privateer\Fabric\Sites\Site;

class BootstrapSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fabric:site {name} {--domain=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bootstrap a new site';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $site = Site::create([
            'name'          => $this->argument('name')
        ]);

        $page = Page::create([
            'name'  => 'Home',
            'site_id'   => $site->id
        ]);

        $content = new Content([
            'title' => 'Welcome to ' . $this->argument('name'),
        ]);

        $page->content()->save($content);

        $site->homepage_id = $page->id;
        $site->save();

        $tld = ( ! empty($this->option('domain'))) ? $this->option('domain') : str_slug($this->argument('name')) . '.dev';

        $domain = new Domain([
            'domain'    => $tld
        ]);

        $site->domains()->save($domain);
    }
}
