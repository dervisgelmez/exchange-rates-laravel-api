<?php

namespace App\Services\ExchangeRates;

use App\Types\ExchangeRates\ExchangeRatesType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ExchangeRatesProviderFactory
{
    /**
     * @var ExchangeRatesAbstract[] $providers
     */
    protected array $providers = [];

    public function __construct(ExchangeRatesAbstract $defaultProvider)
    {
        $this->addProvider($defaultProvider);
    }

    /**
     * @param ExchangeRatesAbstract ...$providers
     * @return void
     */
    public function addProvider(ExchangeRatesAbstract ...$providers): void
    {
        foreach ($providers as $provider) {
            $this->providers[] = $provider;
        }
    }

    /**
     * @return ExchangeRatesType
     */
    public function fetchExchangeRates(): ExchangeRatesType {
        foreach ($this->providers as $provider) {
            try {
                return $provider->getRates();
            } catch (\Exception $exception) {
                //log
            }
        }
        throw new NotFoundHttpException();
    }
}
