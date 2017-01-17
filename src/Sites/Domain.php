<?php

namespace Privateer\Fabric\Sites;

use Illuminate\Database\Eloquent\Model;
use Privateer\Fabric\ConnectionTrait;
use Privateer\Uuid\EloquentUuid;

class Domain extends Model
{
    use EloquentUuid, ConnectionTrait;

    protected $guarded = [];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
