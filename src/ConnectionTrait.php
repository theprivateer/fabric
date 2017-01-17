<?php

namespace Privateer\Fabric;


trait ConnectionTrait
{
    public function getConnectionName()
    {
        return config('fabric.database-connection', config('database.default'));
    }
}