<?php

namespace App\Providers;

use App\Services\ExchangeRates\ExchangeRatesAbstract;
use App\Services\ExchangeRates\ExchangeRatesProviderFactory;
use App\Services\ExchangeRates\Providers\DefaultExchangeRatesApi;
use App\Services\ExchangeRates\Providers\IsBankProviderService;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class ExchangeRatesProvider extends ServiceProvider
{
    private ExchangeRatesAbstract $provider;

    public function register(): void
    {
        switch (config('exchangerates.default_provider')) {
            case 'isBank':
                $this->provider = new IsBankProviderService();
                break;
            default:
                $this->provider = new DefaultExchangeRatesApi();
                break;
        }

        $this->app->bind(ExchangeRatesProviderFactory::class, function () {
            return new ExchangeRatesProviderFactory($this->provider);
        });
    }
}
