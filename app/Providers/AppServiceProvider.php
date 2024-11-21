<?php

namespace App\Providers;

use App\Model\Product;
use App\Model\ProductStock;
use App\Observers\ProductObserver;
use App\Observers\RestockObserver;
use Illuminate\Support\Facades\Schema;
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
        // Observers
        Product::observe(ProductObserver::class);
        ProductStock::observe(RestockObserver::class);

        Schema::defaultStringLength(191);
    }
}
