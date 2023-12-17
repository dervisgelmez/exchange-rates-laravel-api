<?php

namespace App\Services\ExchangeRates;

interface ExchangeRatesParserInterface
{
    /**
     * @param $data
     * @return string
     */
    public function parseCode($data): string;

    /**
     * @param $data
     * @return string|null
     */
    public function parseDescription($data): ?string;

    /**
     * @param $data
     * @return float
     */
    public function parseRateBuy($data): float;

    /**
     * @param $data
     * @return float
     */
    public function parseRateSell($data): float;

    /**
     * @param $response
     * @return array
     */
    public function parseBody($response): array;

    /**
     * @return array
     */
    public function getRates(): array;
}
