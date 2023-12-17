<?php

namespace App\Services\ExchangeRates;

interface ExchangeRatesRequestInterface
{
    /**
     * @return string
     */
    public function getRequestUrl(): string;

    /**
     * @return string
     */
    public function getRequestMethod(): string;

    /**
     * @return array
     */
    public function getRequestOptions(): array;
}
