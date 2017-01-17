<?php

namespace Privateer\Fabric\Sites;

use Illuminate\Support\Facades\DB;
use Privateer\Fabric\Articles\Article;
use Privateer\Fabric\ConnectionTrait;
use Privateer\Fabric\Sites\Navigation\Index;
use Privateer\Fabric\Uploads\Image;
use Illuminate\Database\Eloquent\Model;
use Privateer\Uuid\EloquentUuid;

class Site extends Model
{
    use EloquentUuid, ConnectionTrait;

    protected $guarded = [];

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function redirects()
    {
        return $this->hasMany(Redirect::class);
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function indices()
    {
        return $this->hasMany(Index::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function meta()
    {
        return $this->morphOne(Meta::class, 'parent');
    }

    public function feed()
    {
        return $this->belongsTo(Page::class, 'feed_page_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function publishedArticles()
    {
        return $this->hasMany(Article::class)
                    ->where('draft', false)
                    ->where('publish_at', '<', DB::raw('NOW()'))
                    ->orderBy('publish_at', 'desc');
    }

    public function getSeoTitle()
    {
        if( ! $this->meta) return $this->name;

        return $this->meta->seo_title;
    }

    public function getSeoDescription()
    {
        if( ! $this->meta) return; // Default description

        return $this->meta->seo_description;
    }

    public function updateWithMeta($formData)
    {
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
}
