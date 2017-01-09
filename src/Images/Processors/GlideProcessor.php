<?php

namespace Privateer\Fabric\Images\Processors;

use League\Glide\Urls\UrlBuilder;
use Privateer\Fabric\Images\ProcessorContract;

class GlideProcessor implements ProcessorContract
{
    public function getUrl($file_name, $parameters)
    {
        $urlBuilder = new UrlBuilder(url('/image'));
        
        return $urlBuilder->getUrl($file_name, $parameters);
    }
    
}