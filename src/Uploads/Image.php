<?php

namespace Privateer\Fabric\Uploads;

use Privateer\Fabric\Images\Imageable;
use Illuminate\Database\Eloquent\Model;
use Privateer\Uuid\EloquentUuid;

class Image extends Model
{
    use EloquentUuid, Imageable;

    protected $guarded = [];
}
