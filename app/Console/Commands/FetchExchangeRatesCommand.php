<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
     */
    public function handle()
    {
        //
    }
}
