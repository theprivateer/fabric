<?php

namespace Privateer\Fabric;


use Illuminate\Support\Str;

trait ConnectionTrait
{
    public function getConnectionName()
    {
        return config('fabric.database-connection', config('database.default'));
    }

    public function getTable()
    {
        if (isset($this->table)) {
            return config('fabric.database-prefix') . $this->table;
        }

        return config('fabric.database-prefix') . str_replace('\\', '', Str::snake(Str::plural(class_basename($this))));
    }
}