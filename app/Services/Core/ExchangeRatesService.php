<?php

namespace App\Services\Core;

use App\Models\ExchangeRate;
use App\Types\ExchangeRates\ExchangeRatesItemType;

final class ExchangeRatesService
{
    /**
     * @param ExchangeRatesItemType $item
     * @return ExchangeRate
     */
    public function saveExchangeRatesItem(ExchangeRatesItemType $item): ExchangeRate
    {
        return ExchangeRate::create([
            'provider_name' => $item->getProviderName(),
            'code' => $item->getCode(),
            'description' => $item->getDescription(),
            'rate_buy' => $item->getRateBuy(),
            'rate_sell' => $item->getRateSell()
        ]);
    }
}
