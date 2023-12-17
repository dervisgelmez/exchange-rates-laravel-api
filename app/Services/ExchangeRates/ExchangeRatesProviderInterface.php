<?php

namespace App\Services\ExchangeRates;

interface ExchangeRatesProviderInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array
     */
    public function getAllowedCodes(): array;

    /**
     * @return array
     */
    public function getRates(): array;
}
