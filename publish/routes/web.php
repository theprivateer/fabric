<?php

Route::group(['namespace' => 'Privateer\Fabric\Http\Controllers', 'middleware' => ['web']], function() {

    if( ! config('fabric.backend-only', false))
    {
        /*
        * Homepage
        */
        if(config('fabric.fabric-homepage')) Route::get('/', 'PageController@index');

        /*
         * Sitemap
         */
        Route::get('sitemap.xml', config('fabric.sitemap'));

        /*
         * Feed
         */
        if( ! Illuminate\Support\Facades\App::runningInConsole() && ! empty(site('feed')))
        {
            Route::get(site('feed')->url . '/{url}', 'ArticleController@show');
            Route::get(site('feed')->url, 'ArticleController@index');
        }
    }

    /*
     * Admin Routes
     */
    Route::group(['prefix' => config('fabric.admin-prefix')], function () {

        // Admin
        Route::group(['namespace' => 'Admin', 'middleware' => config('fabric.auth-middleware')], function () {

            Route::get('/', [
                'uses'  => 'DashboardController@show',
                'as'    => 'fabric::home'
            ]);

            Route::get('/home', function() {
                return redirect()->route('fabric::home');
            });

            Route::group(['namespace' => 'Sites'], function() {

                Route::group(['prefix' => 'site'], function () {
                    /*
                     * Creation
                     */
                    Route::get('create', [
                        'uses'  => 'SiteController@create',
                        'as'    => 'fabric::site.create'
                    ]);

                    Route::post('create', [
                        'uses'  => 'SiteController@store',
                        'as'    => 'fabric::site.create'
                    ]);

                    /*
                     * General Settings
                     */
                    Route::get('edit', [
                        'uses'  => 'SiteController@edit',
                        'as'    => 'fabric::site.edit'
                    ]);

                    Route::post('edit', [
                        'uses'  => 'SiteController@update',
                        'as'    => 'fabric::site.edit'
                    ]);

                    /*
                     * Domains
                     */
                    Route::get('domains', [
                        'uses'  => 'DomainController@index',
                        'as'    => 'fabric::domain.index'
                    ]);

                    Route::get('domain/create', [
                        'uses'  => 'DomainController@create',
                        'as'    => 'fabric::domain.create'
                    ]);

                    Route::post('domain/create', [
                        'uses'  => 'DomainController@store',
                        'as'    => 'fabric::domain.create'
                    ]);

                    Route::get('domain/{uuid}/edit', [
                        'uses'  => 'DomainController@edit',
                        'as'    => 'fabric::domain.edit'
                    ]);

                    Route::post('domain/{uuid}/edit', [
                        'uses'  => 'DomainController@update',
                        'as'    => 'fabric::domain.edit'
                    ]);

                    Route::delete('domain', [
                        'uses'  => 'DomainController@destroy',
                        'as'    => 'fabric::domain.destroy'
                    ]);

                    /*
                     * Redirects
                     */
                    Route::get('redirects', [
                        'uses'  => 'RedirectController@index',
                        'as'    => 'fabric::redirect.index'
                    ]);

                    Route::get('redirect/create', [
                        'uses'  => 'RedirectController@create',
                        'as'    => 'fabric::redirect.create'
                    ]);

                    Route::post('redirect/create', [
                        'uses'  => 'RedirectController@store',
                        'as'    => 'fabric::redirect.create'
                    ]);

                    Route::get('redirect/{uuid}/edit', [
                        'uses'  => 'RedirectController@edit',
                        'as'    => 'fabric::redirect.edit'
                    ]);

                    Route::post('redirect/{uuid}/edit', [
                        'uses'  => 'RedirectController@update',
                        'as'    => 'fabric::redirect.edit'
                    ]);

                    Route::delete('redirect', [
                        'uses'  => 'RedirectController@destroy',
                        'as'    => 'fabric::redirect.destroy'
                    ]);
                });
            });

            Route::group(['namespace' => 'Pages'], function () {
                /*
                 * Site Page Index
                 */
                Route::get('pages', [
                    'uses'  => 'PageController@index',
                    'as'    => 'fabric::page.index'
                ]);

                Route::group(['prefix' => 'page'], function () {
                    /*
                     * Creation
                     */
                    Route::get('create', [
                        'uses'  => 'PageController@create',
                        'as'    => 'fabric::page.create'
                    ]);

                    Route::post('create', [
                        'uses'  => 'PageController@store',
                        'as'    => 'fabric::page.create'
                    ]);

                    /*
                     * General Settings
                     */
                    Route::get('{uuid}/edit', [
                        'uses'  => 'PageController@edit',
                        'as'    => 'fabric::page.edit'
                    ]);

                    Route::post('{uuid}/edit', [
                        'uses'  => 'PageController@update',
                        'as'    => 'fabric::page.edit'
                    ]);

                    Route::delete('/', [
                        'uses'  => 'PageController@destroy',
                        'as'    => 'fabric::page.destroy'
                    ]);
                });
            });

            Route::group(['namespace' => 'Articles'], function () {
                /*
                 * Site Page Index
                 */
                Route::get('articles', [
                    'uses'  => 'ArticleController@index',
                    'as'    => 'fabric::article.index'
                ]);

                Route::group(['prefix' => 'article'], function () {
                    /*
                     * Creation
                     */
                    Route::get('create', [
                        'uses'  => 'ArticleController@create',
                        'as'    => 'fabric::article.create'
                    ]);

                    Route::post('create', [
                        'uses'  => 'ArticleController@store',
                        'as'    => 'fabric::article.create'
                    ]);

                    /*
                     * General Settings
                     */
                    Route::get('{uuid}/edit', [
                        'uses'  => 'ArticleController@edit',
                        'as'    => 'fabric::article.edit'
                    ]);

                    Route::post('{uuid}/edit', [
                        'uses'  => 'ArticleController@update',
                        'as'    => 'fabric::article.edit'
                    ]);

                    Route::delete('/', [
                        'uses'  => 'ArticleController@destroy',
                        'as'    => 'fabric::article.destroy'
                    ]);
                });
            });

            Route::group(['namespace' => 'Indices'], function () {

                Route::get('indices', [
                    'uses'  => 'IndexController@index',
                    'as'    => 'fabric::index.index'
                ]);

                Route::group(['prefix' => 'index'], function () {
                    /*
                     * Creation
                     */
                    Route::get('create', [
                        'uses'  => 'IndexController@create',
                        'as'    => 'fabric::index.create'
                    ]);

                    Route::post('create', [
                        'uses'  => 'IndexController@store',
                        'as'    => 'fabric::index.create'
                    ]);

                    /*
                     * General Settings
                     */
                    Route::get('{uuid}/edit', [
                        'uses'  => 'IndexController@edit',
                        'as'    => 'fabric::index.edit'
                    ]);

                    Route::post('{uuid}/edit', [
                        'uses'  => 'IndexController@update',
                        'as'    => 'fabric::index.edit'
                    ]);

                    Route::delete('/', [
                        'uses'  => 'IndexController@destroy',
                        'as'    => 'fabric::index.destroy'
                    ]);
                });
            });

            Route::group(['namespace' => 'Uploads'], function () {

                Route::post('upload/image', [
                    'uses'  => 'ImageController@store',
                    'as'    => 'fabric::image.create'
                ]);

                Route::get('uploads/grid', [
                    'uses'  => 'ImageController@grid',
                    'as'     => 'fabric::image.grid'
                ]);

                Route::post('image/tag', [
                    'uses'  => 'ImageController@generateTag',
                    'as'     => 'fabric::image.tag'
                ]);
            });


        });
    });

    /*
     * Wildcards
     */
    Route::get('image/{path}', [
        'uses' => 'ImageController@show',
        'as'   => 'fabric::image.src'
    ])->where('path', '.*');

    if( ! config('fabric.backend-only', false)) Route::get('{path}', 'PageController@show')->where('path', '.*');
});