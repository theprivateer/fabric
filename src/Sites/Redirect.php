<?php

namespace Privateer\Fabric\Sites;

use Illuminate\Database\Eloquent\Model;
use Privateer\Uuid\EloquentUuid;

class Redirect extends Model
{
    use EloquentUuid;
    
    protected $guarded = [];
}
