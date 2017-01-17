<?php

namespace Privateer\Fabric\Sites;

use Illuminate\Database\Eloquent\Model;
use Privateer\Fabric\ConnectionTrait;
use Privateer\Uuid\EloquentUuid;

class Setting extends Model
{
    use EloquentUuid, ConnectionTrait;

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
