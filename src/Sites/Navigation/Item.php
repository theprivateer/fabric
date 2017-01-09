<?php

namespace Privateer\Fabric\Sites\Navigation;

use Illuminate\Database\Eloquent\Model;
use Privateer\Uuid\EloquentUuid;

class Item extends Model
{
    use EloquentUuid;

    protected $guarded = [];

    public function index()
    {
        return $this->belongsTo(Index::class);
    }

    public function model()
    {
        return $this->morphTo();
    }
}
