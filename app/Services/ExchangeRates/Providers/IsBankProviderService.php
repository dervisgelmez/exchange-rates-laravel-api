<?php

namespace App\Services\ExchangeRates\Providers;


use App\Services\ExchangeRates\ExchangeRatesAbstract;

class IsBankProviderService extends ExchangeRatesAbstract
{
    public function getName(): string
    {
        return 'isBank';
    }

    public function getRequestUrl(): string
    {
        return 'https://www.isbank.com.tr/_vti_bin/DV.Isbank/PriceAndRate/PriceAndRateService.svc/GetFxRates?Lang=tr&fxRateType=IB&date='.date('Y-m-d');
    }

    public function parseDescription($data): ?string
    {
        return $data['description'];
    }

    public function parseCode($data): string
    {
        return $data['code'];
    }

    public function parseRateBuy($data): float
    {
        return $data['fxRateBuy'];
    }

    public function parseRateSell($data): float
    {
        return $data['fxRateSell'];
    }

    public function parseBody($response): array
    {
        $responseArray = json_decode($response, true);
        return $responseArray['Data'];
    }
}
