<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer(
            \App\Common\Constant::FOLDER_URL_FRONTEND . '.layouts.headers.header',
            function ($view) {
                $view->with('listCategories', \App\Models\FrontEnd\Category\Category::all());
            }
        );
    }
}
