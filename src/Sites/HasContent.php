<?php

namespace Privateer\Fabric\Sites;

use Privateer\Fabric\Sites\Content;

trait HasContent
{

    /**
     * Content
     */
    public function content()
    {
        return $this->morphOne(Content::class, 'parent');
    }

    public function getTitle($before = null, $after = null, $default = null)
    {
        if( ! $this->content) return $before . $default . $after;

        $title = ($this->content->title !== null) ? $this->content->title : $default;

        return $before . $title . $after;
    }

    public function getExcerpt($parseMarkdown = true, $before = null, $after = null)
    {
        if( ! $this->content) return;

        $excerpt = ($parseMarkdown) ? parse_markdown($this->content->excerpt) : $this->content->excerpt;

        return $before . $excerpt . $after;
    }

    public function getBody($parseMarkdown = true, $before = null, $after = null)
    {
        if( ! $this->content) return;

        $body = ($parseMarkdown) ? parse_markdown($this->content->body) : $this->content->body;

        return $before . $body . $after;
    }

    public function featuredImage($parameters = [], $attributes = [])
    {
        if( ! $this->content || ! $this->content->image) return;

        return $this->content->image->getTag($parameters, $attributes);
    }

    public function featuredImagePath($parameters = [])
    {
        if( ! $this->content || ! $this->content->image) return;

        return $this->content->image->getPath($parameters);
    }

    public function featuredImageId()
    {
        if( ! $this->content || ! $this->content->image) return;

        return $this->content->image->id;
    }

}