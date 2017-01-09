<?php

namespace Privateer\Fabric\Sites;

use Illuminate\Database\Eloquent\Model;
use Privateer\Uuid\EloquentUuid;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
    use EloquentUuid, HasSlug, HasContent;

    protected $guarded = [];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }


    /**
     * SEO Meta
     */
    public function meta()
    {
        return $this->morphOne(Meta::class, 'parent');
    }

    public function getSeoTitle()
    {
        if( ! $this->meta || empty($this->meta->seo_title)) return $this->site->getSeoTitle();

        return $this->meta->seo_title;
    }

    public function getSeoDescription()
    {
        if( ! $this->meta || empty($this->meta->seo_description)) return $this->site->getSeoDescription();

        return $this->meta->seo_description;
    }

    /**
     * Create
     */
    public static function createForSite($formData, $siteId)
    {
        $page = self::create([
            'site_id'   => $siteId,
            'name'      => $formData['name'],
            'template'  => $formData['template'],
        ]);

        $page->content()->save(new Content(
            (isset($formData['content'])) ? $formData['content'] : [])
        );

        $page->meta()->save(new Meta(
            (isset($formData['meta'])) ? $formData['meta'] : [])
        );

        return $page;
    }

    /**
     * Update
     */
    public function updateWithContent($formData)
    {
        if(isset($formData['content']))
        {
            if( ! $this->content)
            {
                $this->content()->save(new Content($formData['content']));
            } else
            {
                $this->content->fill($formData['content']);
                $this->content->save();
            }

            unset($formData['content']);
        }

        if(isset($formData['meta']))
        {
            if( ! $this->meta)
            {
                $this->meta()->save(new Meta($formData['meta']));
            } else
            {
                $this->meta->fill($formData['meta']);
                $this->meta->save();
            }

            unset($formData['meta']);
        }

        // First, the model data...
        $this->fill($formData);

        $this->save();

        return;
    }


    public function remove()
    {
        if($this->content) $this->content->delete();
        if($this->meta) $this->meta->delete();

        // Setup a redirect
        $redirect = new Redirect([
            'old_url'   => $this->url,
            'new_url'   => '/'
        ]);

        $this->site->redirects()->save($redirect);

        $this->delete();

        return;
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('url');
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
