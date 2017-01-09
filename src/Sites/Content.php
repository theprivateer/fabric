<?php

namespace Privateer\Fabric\Sites;

use Privateer\Fabric\Uploads\Image;
use Illuminate\Database\Eloquent\Model;
use Privateer\Uuid\EloquentUuid;

class Content extends Model
{
    use EloquentUuid;

    protected $guarded = [];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
