<?php

namespace App\Types\ExchangeRates;

class ExchangeRatesType
{
    /**
     * @var string
     */
    private string $providerName;

    /**
     * @var ExchangeRatesItemType[]
     */
    private array $exchangeRatesItems;

    public function __construct(?string $providerName)
    {
        $this->providerName = $providerName;
    }

    public function __toString(): string
    {
        return (string)count($this->exchangeRatesItems);
    }

    public function getProviderName(): string
    {
        return $this->providerName;
    }

    public function setProviderName(string $providerName): void
    {
        $this->providerName = $providerName;
    }

    public function getExchangeRatesItems(): array
    {
        return $this->exchangeRatesItems;
    }

    public function addExchangeRatesItem(ExchangeRatesItemType $exchangeRatesItem): void
    {
        $exchangeRatesItem->setProviderName($this->getProviderName());
        $this->exchangeRatesItems[] = $exchangeRatesItem;
    }
}
