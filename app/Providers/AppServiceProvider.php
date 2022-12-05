<?php

namespace App\Providers;

use App\Repositories\CityRepository;
use App\Repositories\Contracts\CityRepositoryContract;
use App\Repositories\Contracts\ProductRepositoryContract;
use App\Repositories\Contracts\WorkorderRepositoryContract;
use App\Repositories\CustomerRepository;
use App\Repositories\Contracts\CustomerRepositoryContract;
use App\Repositories\ServiceRepository;
use App\Repositories\ProductRepository;
use App\Repositories\WorkorderRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\ServiceRepositoryContract;

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
        $this->app->bind(CustomerRepositoryContract::class, CustomerRepository::class);
        $this->app->bind(ServiceRepositoryContract::class, ServiceRepository::class);
        $this->app->bind(CityRepositoryContract::class, CityRepository::class);
        $this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
        $this->app->bind(WorkorderRepositoryContract::class, WorkorderRepository::class);
    }
}
