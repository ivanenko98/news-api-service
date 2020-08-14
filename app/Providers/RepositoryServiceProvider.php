<?php

namespace App\Providers;

use App\Entities\News;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Repositories\NewsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NewsRepositoryInterface::class, function($app) {
//            $app['em']->getClassMetaData(News::class)->setTableName('news');


            return new NewsRepository(
                $app['em'],
                $app['em']->getClassMetaData(News::class)
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
