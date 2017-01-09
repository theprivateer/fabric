<?php

return [

    'admin-prefix' => '.admin',

    'upload-prefix' => 'uploads',

    'site' => \Privateer\Fabric\Sites\Site::class,

    'sitemap' => '\Privateer\Fabric\Http\Controllers\SitemapController@show',

    'auth-middleware'   => 'auth', // default

    'processor' => 'glide', // 'default

    'processors' => [ // 'drivers'
        'glide' => [
            'class'         => \Privateer\Fabric\Images\Processors\GlideProcessor::class,
            'filesystem'    => 'local', // default to whatever the default filesystem is
            'cache'         => 'local'
        ],
        'imgix' => [
            'class'             => \Privateer\Fabric\Images\Processors\ImgixProcessor::class,
            'source_server'     => '',
            'source_signature'  => '',
            'source_prefix'     => ''
        ]
    ],

    'preview-image-parameters' => [
        'w'     => 300,
        'h'     => 300,
        'fit'   => 'crop',
    ],
];