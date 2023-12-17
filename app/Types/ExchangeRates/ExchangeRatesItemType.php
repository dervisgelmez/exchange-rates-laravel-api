<?php

namespace App\Types\ExchangeRates;

class ExchangeRatesItemType
{
    private string $code;

    private string $providerName;

    private ?string $description;

    private float $rateBuy;

    private float $rateSell;

    public static function fill(
        string $code, ?
        string $description,
        float  $rateBuy,
        float  $rateSell
    ): static
    {
        $type = new static();
        $type->code = $code;
        $type->description = $description;
        $type->rateBuy = $rateBuy;
        $type->rateSell = $rateSell;
        return $type;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getProviderName(): string
    {
        return $this->providerName;
    }

    public function setProviderName(string $providerName): void
    {
        $this->providerName = $providerName;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getRateBuy(): float
    {
        return $this->rateBuy;
    }

    public function setRateBuy(float $rateBuy): void
    {
        $this->rateBuy = $rateBuy;
    }

    public function getRateSell(): float
    {
        return $this->rateSell;
    }

    public function setRateSell(float $rateSell): void
    {
        $this->rateSell = $rateSell;
    }
}
