<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ExchangeRatesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests the retrieval and structure of exchange rates data.
     * @return void
     */
    public function test_exchange_rates(): void
    {
        Artisan::call('fetch:exchange-rates');

        $response = $this
            ->makeResponseWithAuthenticatedUser()
            ->get('api/exchange-rates');

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'current_page',
                'data' => [
                    '*' => [
                        'code',
                        'description',
                        'rate_buy',
                        'rate_sell',
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links' => [
                    '*' => [
                        'url',
                        'label',
                        'active',
                    ]
                ],
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ]
        ]);

        $this->assertTrue(true);
    }
}
