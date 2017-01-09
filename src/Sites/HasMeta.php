<?php

namespace Privateer\Fabric\Sites;

use Privateer\Fabric\Sites\Meta;

trait HasMeta
{

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
}