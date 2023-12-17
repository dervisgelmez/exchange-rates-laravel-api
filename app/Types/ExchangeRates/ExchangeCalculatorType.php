<?php

namespace App\Types\ExchangeRates;

class ExchangeCalculatorType
{
    private string $fromCode;

    private float $fromRate;

    private string $toCode;

    private float $toRate;

    private float $amount;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->amount} {$this->fromCode} is {$this->calculate()} {$this->toCode}";
    }

    public function getFromCode(): string
    {
        return $this->fromCode;
    }

    public function setFromCode(string $fromCode): void
    {
        $this->fromCode = $fromCode;
    }

    public function getFromRate(): float
    {
        return $this->fromRate;
    }

    public function setFromRate(float $fromRate): void
    {
        $this->fromRate = $fromRate;
    }

    public function getToCode(): string
    {
        return $this->toCode;
    }

    public function setToCode(string $toCode): void
    {
        $this->toCode = $toCode;
    }

    public function getToRate(): float
    {
        return $this->toRate;
    }

    public function setToRate(float $toRate): void
    {
        $this->toRate = $toRate;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function calculate(): float
    {
        return $this->fromRate * $this->amount / $this->toRate;
    }
}
