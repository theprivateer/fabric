# Fabric
## An simple opinionated Content Management framework for your Laravel app

__Important:__ Add the following to the _end_ of the Service Providers array:

`Privateer\Fabric\Providers\FabricServiceProvider::class,`

Run command to publish the config files:

`php artisan vendor:publish --provider="Privateer\Fabric\Providers\FabricServiceProvider" --tag=config --force`

Then migrate:

`php artisan migrate`


To Enable redirects, register the following:
```
//app/Http/Kernel.php

protected $middleware = [
       ...
       \Spatie\MissingPageRedirector\RedirectsMissingPages::class,
    ],
```

Add middleware to 'web' group:

```
//app/Http/Kernel.php
'web' => [
            ...
            \Privateer\Fabric\Http\Middleware\GetSite::class,
        ],
```