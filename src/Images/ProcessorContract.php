<?php

namespace Privateer\Fabric\Images;


interface ProcessorContract
{
    public function getUrl($file_name, $parameters);

}