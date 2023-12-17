<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Services\Cache\RequestCacheService;
use App\Services\Core\ExchangeRatesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ExchangeRatesController extends ApiBaseController
{
    /**
     * @param Request $request
     * @param ExchangeRatesService $exchangeRatesService
     * @return JsonResponse
     */
    public function index(Request $request, ExchangeRatesService $exchangeRatesService): JsonResponse
    {
        if (RequestCacheService::hashCache($request)) {
            return $this->successResponse(
                RequestCacheService::getCache($request)
            );
        }

        $exchangeRatesBuilder = $exchangeRatesService->getExchangeRates($request);
        $response = $exchangeRatesBuilder->paginate($request->query->get('count', 15))->toArray();

        RequestCacheService::saveCache($request, $response);

        return $this->successResponse($response);
    }

    /**
     * @param Request $request
     * @param ExchangeRatesService $exchangeRatesService
     * @return JsonResponse
     */
    public function calculate(Request $request, ExchangeRatesService $exchangeRatesService): JsonResponse
    {
        $validatableCodesString = implode(',', $exchangeRatesService->getValidatableCodes());

        $request->validate([
            'from'   => 'string|in:' . "{$validatableCodesString}",
            'to'     => 'required|string|in:' . "{$validatableCodesString}",
            'amount' => 'required|numeric|min:0',
            ],
            [
                'from.string'     => 'From field must be a string',
                'from.in'         => "Invalid 'from' currency. Supported currencies: [{$validatableCodesString}]",
                'to.required'     => 'To parameter is required',
                'to.string'       => 'To parameter must be a string',
                'to.in'           => "Invalid 'to' parameter. Supported currencies: [{$validatableCodesString}]",
                'amount.required' => 'Amount is required',
                'amount.numeric'  => 'Amount must be numeric',
                'amount.min'      => 'Amount must be greater than or equal to 0'
            ]
        );

        $calculated = $exchangeRatesService->calculate($request);

        return $this->successResponse($calculated);
    }
}
