<?php

namespace App\Services\Core;

use App\Models\ExchangeRate;
use App\Types\ExchangeRates\ExchangeCalculatorType;
use App\Types\ExchangeRates\ExchangeRatesItemType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

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

    /**
     * @param Carbon $fromDate
     * @return void
     */
    public function clearExpiredExchangeRatesItems(Carbon $fromDate): void
    {
        ExchangeRate::query()->where('created_at', '<', $fromDate)->delete();
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function getExchangeRates(Request $request): Builder
    {
        $exchangeRatesBuilder = $this->search($request);
        if ($exchangeRatesBuilder->get()->isEmpty()) {
            Artisan::call('fetch:exchange-rates');
            $exchangeRatesBuilder = $this->search($request);
        }

        return $exchangeRatesBuilder;
    }

    /**
     * @param Request $request
     * @return Builder
     */
    public function search(Request $request): Builder
    {
        $exchangeRates = ExchangeRate::query()->where("created_at", ">=", Carbon::now()->subMinutes(15)->toDateTimeString());
        if ($request->query->get('code')) {
            $exchangeRates->where(DB::raw('LOWER(code)'), '=', strtolower($request->input('code')));
        }
        if ($request->query->get('description')) {
            $exchangeRates->where(DB::raw('LOWER(description)'), 'LIKE', "%".strtolower($request->input('description')."%"));
        }

        return $exchangeRates;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function calculate(Request $request): array
    {
        $calculator = new ExchangeCalculatorType();
        $calculator->setFromCode($request->request->get('from', $this->getDefaultCode()));
        $calculator->setToCode($request->request->get('to'));
        $calculator->setAmount($request->request->get('amount'));

        if ($calculator->getFromCode() == $this->getDefaultCode()) {
            $calculator->setFromRate(1);
        } else {
            $fromExchangeRate = $this->getExchangeRates(new Request(['code' => $calculator->getFromCode()]))->first();
            $calculator->setFromRate($fromExchangeRate->rate_buy);
        }

        if ($calculator->getToCode() == $this->getDefaultCode()) {
            $calculator->setToRate(1);
        } else {
            $toCodeExchangeRate = $this->getExchangeRates(new Request(['code' => $calculator->getToCode()]))->first();
            $calculator->setToRate($toCodeExchangeRate->rate_buy);
        }

        return [
            "message" => (string)$calculator,
            "total"  => $calculator->calculate()
        ];
    }

    public function getDefaultCode(): string
    {
        return config('exchangerates.default_code');
    }

    /**
     * @return array
     */
    public function getValidatableCodes(): array
    {
        $allowedCodes = $this->getAllowedCodes();
        $allowedCodes[] = $this->getDefaultCode();

        return $allowedCodes;
    }

    /**
     * @return array
     */
    public function getAllowedCodes(): array
    {
        return config('exchangerates.allowed_codes');
    }
}
