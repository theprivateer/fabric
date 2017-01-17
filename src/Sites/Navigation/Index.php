<?php

namespace Privateer\Fabric\Sites\Navigation;

use Privateer\Fabric\ConnectionTrait;
use Privateer\Fabric\Sites\Page;
use Privateer\Fabric\Sites\Site;
use Illuminate\Database\Eloquent\Model;
use Privateer\Uuid\EloquentUuid;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Index extends Model
{
    use EloquentUuid, HasSlug, ConnectionTrait;

    protected $guarded = [];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class)->orderBy('sort', 'ASC');
    }

    public function availableItems()
    {
        $ignore = [
            'Privateer\Fabric\Sites\Page' => [],
            'Privateer\Fabric\Sites\Navigation\Index' => [ $this->id ]
        ];

        foreach($this->items as $item)
        {
            $ignore[$item->model_type][] = $item->model_id;
        }

        $available = [];

        $available['Privateer\Fabric\Sites\Page'] = $this->site->pages->except($ignore['Privateer\Fabric\Sites\Page']);
        $available['Privateer\Fabric\Sites\Navigation\Index'] = $this->site->indices->except($ignore['Privateer\Fabric\Sites\Navigation\Index']);

        return collect($available);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('short_name');
    }

    /**
     * Need to override to allow for different sites in database
     */
    protected function otherRecordExistsWithSlug(string $slug): bool
    {
        return (bool) static::where($this->slugOptions->slugField, $slug)
            ->where('site_id', '=', $this->getAttribute('site_id') ?? '0' )
            ->where($this->getKeyName(), '!=', $this->getKey() ?? '0')
            ->first();
    }
}
