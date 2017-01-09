<?php

namespace Privateer\Fabric\Articles;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Privateer\Fabric\Sites\Content;
use Privateer\Fabric\Sites\HasContent;
use Privateer\Fabric\Sites\HasMeta;
use Privateer\Fabric\Sites\Meta;
use Privateer\Fabric\Sites\Redirect;
use Privateer\Fabric\Sites\Site;
use Privateer\Uuid\EloquentUuid;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends Model
{
    use EloquentUuid, HasSlug, HasContent, HasMeta;

    protected $guarded = [];

    protected $dates = ['publish_at'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public static function createForSite($formData, $siteId, $userId)
    {
        if( ! $formData['draft'])
        {
            $formData['publish_at'] = (empty($formData['publish_at'])) ? Carbon::today() : $formData['publish_at'];
        } elseif(empty($formData['publish_at']))
        {
            unset($formData['publish_at']);
        }

        $article = self::create([
            'site_id'   => $siteId,
            'user_id'   => $userId,
            'name'      => $formData['name'],
            'draft'     => $formData['draft'],
        ]);

        $article->content()->save(new Content(
                (isset($formData['content'])) ? $formData['content'] : [])
        );

        $article->meta()->save(new Meta(
                (isset($formData['meta'])) ? $formData['meta'] : [])
        );

        return $article;
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

        if( ! $formData['draft'])
        {
            $formData['publish_at'] = (empty($formData['publish_at'])) ? Carbon::today() : $formData['publish_at'];
        } elseif(empty($formData['publish_at']))
        {
            unset($formData['publish_at']);
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
            'old_url'   => $this->getPrefixedUrlAttribute(),
            'new_url'   => '/'
        ]);

        $this->site->redirects()->save($redirect);

        $this->delete();

        return;
    }

    public function getPrefixedUrlAttribute()
    {
        return '/' . $this->site->feed->url . '/' . $this->url;
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