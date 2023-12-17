<?php

namespace App\Services\ExchangeRates;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request;

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

    public function getRates(): array
    {
        $response = [];
        foreach ($this->fetch() as $item) {
           $response[] = $item;
        }
        return $response;
    }
}