<?php

namespace App\Console\Commands;

use App\Services\Core\ExchangeRatesService;
use App\Services\ExchangeRates\ExchangeRatesProviderFactory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchExchangeRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:exchange-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch exchange rates from defined providers';

    /**
     * Execute the console command.
     * @param ExchangeRatesProviderFactory $factory
     * @param ExchangeRatesService $exchangeRatesService
     */
    public function handle(
        ExchangeRatesProviderFactory $factory,
        ExchangeRatesService $exchangeRatesService
    ): void
    {
        $this->newLine();
        $this->line("💥 Process start ". Carbon::now());
        $this->newLine();

        $this->line('⏳️ Fetching data...');

        $exchangeRates = $factory->fetchExchangeRates();
        $this->line("🔎 Found {$exchangeRates} items from {$exchangeRates->getProviderName()} provider.");
        foreach ($exchangeRates->getExchangeRatesItems() as $exchangeRatesItem) {
            try {
                $exchangeRatesService->saveExchangeRatesItem($exchangeRatesItem);
                $this->info("{$exchangeRatesItem->getCode()} saved to database...");
            } catch (\Exception $e) {
                $exceptionMessage = "{$exchangeRatesItem->getCode()} not saved to database {$e->getMessage()}";
                Log::alert($exceptionMessage);
                $this->error($exceptionMessage);
            }
        }

        $this->newLine();
        $this->info("✅ Completed process ". Carbon::now());
    }
}
