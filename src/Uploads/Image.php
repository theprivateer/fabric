<?php

namespace Privateer\Fabric\Uploads;

use Privateer\Fabric\ConnectionTrait;
use Privateer\Fabric\Images\Imageable;
use Illuminate\Database\Eloquent\Model;
use Privateer\Uuid\EloquentUuid;

class Image extends Model
{
    use EloquentUuid, Imageable, ConnectionTrait;

    protected $guarded = [];
}
