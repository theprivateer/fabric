<?php

namespace Privateer\Fabric\Images;

use Illuminate\Database\Eloquent\Model;
use Privateer\Fabric\ConnectionTrait;
use Privateer\Fabric\Sites\Content;
use Privateer\Fabric\Uploads\Image;
use Privateer\Uuid\EloquentUuid;

class Slide extends Model
{
    use EloquentUuid, ConnectionTrait;

    protected $guarded = [];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
