<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\GaleriGold\Contracts\PriceFetcherInterface::class, function () {
            return new \App\Services\GaleriGold\GaleriGoldFetcher('https://galeri24.co.id/harga-emas');
        });

        $this->app->singleton(\App\Services\GaleriGold\Contracts\PriceParserInterface::class, \App\Services\GaleriGold\GaleriGoldParser::class);
        $this->app->singleton(\App\Services\GaleriGold\Contracts\PricePersisterInterface::class, \App\Services\GaleriGold\GoldPricePersister::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
