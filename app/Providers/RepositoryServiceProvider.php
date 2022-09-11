<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->when(\App\Http\Services\LinkService::class)
            ->needs(\App\Http\Contracts\Repositories\LinkRepository::class)->give(\App\Http\Repositories\Links\Eloquent\LinkRepository::class);

    }//end register()

}//end class
