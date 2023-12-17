<?php

namespace App\Services\ExchangeRates;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request;
use App\Types\ExchangeRates\ExchangeRatesType;
use App\Types\ExchangeRates\ExchangeRatesItemType;

abstract class ExchangeRatesAbstract implements ExchangeRatesRequestInterface, ExchangeRatesProviderInterface, ExchangeRatesParserInterface
{
    public function getAllowedCodes(): array
    {
        return config('exchangerates.allowed_codes');
    }

    public function getRequestMethod(): string
    {
        return Request::METHOD_GET;
    }

    public function getRequestOptions(): array
    {
        return [];
    }
    private function fetch(): array
    {
        $response = [];
        try {
            $request = (new Client())->request(
                $this->getRequestMethod(),
                $this->getRequestUrl(),
                $this->getRequestOptions()
            );
            $response = $this->parseBody($request->getBody());
        } catch (TransferException|GuzzleException $e) {
            Log::alert("Exception {$e->getMessage()} from: {$this->getRequestUrl()} ");
        }
        return $response;
    }

    /**
     * @return ExchangeRatesType
     */
    public function getRates(): ExchangeRatesType
    {
        $exchangeRatesResponse = new ExchangeRatesType($this->getName());
        foreach ($this->fetch() as $item) {
            if (in_array($this->parseCode($item), $this->getAllowedCodes())) {
                $exchangeRatesResponse->addExchangeRatesItem(
                    ExchangeRatesItemType::fill(
                        $this->parseCode($item),
                        $this->parseDescription($item),
                        $this->parseRateBuy($item),
                        $this->parseRateSell($item)
                    )
                );
            }
        }
        return $exchangeRatesResponse;
    }
}
