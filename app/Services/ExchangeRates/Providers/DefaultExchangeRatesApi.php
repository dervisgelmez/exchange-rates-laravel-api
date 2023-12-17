<?php

namespace App\Services\ExchangeRates\Providers;

use App\Services\ExchangeRates\ExchangeRatesAbstract;
use Symfony\Component\HttpFoundation\Request;

final class DefaultExchangeRatesApi extends ExchangeRatesAbstract
{
    public function getName(): string
    {
        return 'default';
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return Request::METHOD_POST;
    }

    public function getRequestUrl(): string
    {
        return 'https://www.exchangeratesprovider.example';
    }

    public function parseCode($data): string
    {
        return $data['Code'];
    }

    public function parseDescription($data): ?string
    {
        return $data['Description'];
    }

    public function parseRateBuy($data): float
    {
        return $data['RateBuy'];
    }

    public function parseRateSell($data): float
    {
        return $data['RateSell'];
    }

    public function parseBody($response): array
    {
        return json_decode($response);
    }
}
