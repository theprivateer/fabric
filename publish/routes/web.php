<?php

Route::group(['namespace' => 'Privateer\Fabric\Http\Controllers', 'middleware' => ['web']], function() {
    /*
    * Homepage
    */
    Route::get('/', 'PageController@index');

    /*
     * Sitemap
     */
    Route::get('sitemap.xml', config('fabric.sitemap'));

    /*
     * Feed
     */
    if( ! Illuminate\Support\Facades\App::runningInConsole())
    {
        Route::get(site('feed')->url . '/{url}', 'ArticleController@show');
        Route::get(site('feed')->url, 'ArticleController@index');
    }

    /*
     * Admin Routes
     */
    Route::group(['prefix' => config('fabric.admin-prefix', '.admin')], function () {

        // Admin
        Route::group(['namespace' => 'Admin', 'middleware' => config('fabric.auth-middleware', 'auth')], function () {

            if( ! Route::has('home'))
            {
                Route::get('/', [
                    'uses'  => 'DashboardController@show',
                    'as'    => 'home'
                ]);
            }

            Route::get('/home', function() {
                return redirect()->route('home');
            });

            Route::group(['namespace' => 'Sites'], function() {
                /*
                 * Site Index (multi-site)
                 */
                //Route::get('sites', [
                //    'uses'  => 'SiteController@index',
                //    'as'    => 'site.index'
                //]);

                Route::group(['prefix' => 'site'], function () {
                    /*
                     * Creation
                     */
                    Route::get('create', [
                        'uses'  => 'SiteController@create',
                        'as'    => 'site.create'
                    ]);

                    Route::post('create', [
                        'uses'  => 'SiteController@store',
                        'as'    => 'site.create'
                    ]);

                    /*
                     * General Settings
                     */
                    Route::get('edit', [
                        'uses'  => 'SiteController@edit',
                        'as'    => 'site.edit'
                    ]);

                    Route::post('edit', [
                        'uses'  => 'SiteController@update',
                        'as'    => 'site.edit'
                    ]);

                    /*
                     * Domains
                     */
                    Route::get('domains', [
                        'uses'  => 'DomainController@index',
                        'as'    => 'domain.index'
                    ]);

                    Route::get('domain/create', [
                        'uses'  => 'DomainController@create',
                        'as'    => 'domain.create'
                    ]);

                    Route::post('domain/create', [
                        'uses'  => 'DomainController@store',
                        'as'    => 'domain.create'
                    ]);

                    Route::get('domain/{uuid}/edit', [
                        'uses'  => 'DomainController@edit',
                        'as'    => 'domain.edit'
                    ]);

                    Route::post('domain/{uuid}/edit', [
                        'uses'  => 'DomainController@update',
                        'as'    => 'domain.edit'
                    ]);

                    Route::delete('domain', [
                        'uses'  => 'DomainController@destroy',
                        'as'    => 'domain.destroy'
                    ]);

                    /*
                     * Redirects
                     */
                    Route::get('redirects', [
                        'uses'  => 'RedirectController@index',
                        'as'    => 'redirect.index'
                    ]);

                    Route::get('redirect/create', [
                        'uses'  => 'RedirectController@create',
                        'as'    => 'redirect.create'
                    ]);

                    Route::post('redirect/create', [
                        'uses'  => 'RedirectController@store',
                        'as'    => 'redirect.create'
                    ]);

                    Route::get('redirect/{uuid}/edit', [
                        'uses'  => 'RedirectController@edit',
                        'as'    => 'redirect.edit'
                    ]);

                    Route::post('redirect/{uuid}/edit', [
                        'uses'  => 'RedirectController@update',
                        'as'    => 'redirect.edit'
                    ]);

                    Route::delete('redirect', [
                        'uses'  => 'RedirectController@destroy',
                        'as'    => 'redirect.destroy'
                    ]);
                });
            });

            Route::group(['namespace' => 'Pages'], function () {
                /*
                 * Site Page Index
                 */
                Route::get('pages', [
                    'uses'  => 'PageController@index',
                    'as'    => 'page.index'
                ]);

                Route::group(['prefix' => 'page'], function () {
                    /*
                     * Creation
                     */
                    Route::get('create', [
                        'uses'  => 'PageController@create',
                        'as'    => 'page.create'
                    ]);

                    Route::post('create', [
                        'uses'  => 'PageController@store',
                        'as'    => 'page.create'
                    ]);

                    /*
                     * General Settings
                     */
                    Route::get('{uuid}/edit', [
                        'uses'  => 'PageController@edit',
                        'as'    => 'page.edit'
                    ]);

                    Route::post('{uuid}/edit', [
                        'uses'  => 'PageController@update',
                        'as'    => 'page.edit'
                    ]);

                    Route::delete('/', [
                        'uses'  => 'PageController@destroy',
                        'as'    => 'page.destroy'
                    ]);
                });
            });

            Route::group(['namespace' => 'Articles'], function () {
                /*
                 * Site Page Index
                 */
                Route::get('articles', [
                    'uses'  => 'ArticleController@index',
                    'as'    => 'article.index'
                ]);

                Route::group(['prefix' => 'article'], function () {
                    /*
                     * Creation
                     */
                    Route::get('create', [
                        'uses'  => 'ArticleController@create',
                        'as'    => 'article.create'
                    ]);

                    Route::post('create', [
                        'uses'  => 'ArticleController@store',
                        'as'    => 'article.create'
                    ]);

                    /*
                     * General Settings
                     */
                    Route::get('{uuid}/edit', [
                        'uses'  => 'ArticleController@edit',
                        'as'    => 'article.edit'
                    ]);

                    Route::post('{uuid}/edit', [
                        'uses'  => 'ArticleController@update',
                        'as'    => 'article.edit'
                    ]);

                    Route::delete('/', [
                        'uses'  => 'ArticleController@destroy',
                        'as'    => 'article.destroy'
                    ]);
                });
            });

            Route::group(['namespace' => 'Indices'], function () {

                Route::get('indices', [
                    'uses'  => 'IndexController@index',
                    'as'    => 'index.index'
                ]);

                Route::group(['prefix' => 'index'], function () {
                    /*
                     * Creation
                     */
                    Route::get('create', [
                        'uses'  => 'IndexController@create',
                        'as'    => 'index.create'
                    ]);

                    Route::post('create', [
                        'uses'  => 'IndexController@store',
                        'as'    => 'index.create'
                    ]);

                    /*
                     * General Settings
                     */
                    Route::get('{uuid}/edit', [
                        'uses'  => 'IndexController@edit',
                        'as'    => 'index.edit'
                    ]);

                    Route::post('{uuid}/edit', [
                        'uses'  => 'IndexController@update',
                        'as'    => 'index.edit'
                    ]);

                    Route::delete('/', [
                        'uses'  => 'IndexController@destroy',
                        'as'    => 'index.destroy'
                    ]);
                });
            });

            Route::group(['namespace' => 'Uploads'], function () {

                Route::post('upload/image', [
                    'uses'  => 'ImageController@store',
                    'as'    => 'image.create'
                ]);

                Route::get('uploads/grid', [
                    'uses'  => 'ImageController@grid',
                    'as'     => 'image.grid'
                ]);

                Route::post('image/tag', [
                    'uses'  => 'ImageController@generateTag',
                    'as'     => 'image.tag'
                ]);
            });


        });
    });

    /*
     * Wildcards
     */
    Route::get('image/{path}', [
        'uses' => 'ImageController@show',
        'as'   => 'image.src'
    ])->where('path', '.*');

    Route::get('{path}', 'PageController@show')->where('path', '.*');
});