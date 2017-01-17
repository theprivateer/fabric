<?php

namespace Privateer\Fabric\Sites;

use Privateer\Fabric\ConnectionTrait;
use Privateer\Fabric\Uploads\Image;
use Illuminate\Database\Eloquent\Model;
use Privateer\Uuid\EloquentUuid;

class Content extends Model
{
    use EloquentUuid, ConnectionTrait;

    protected $guarded = [];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
