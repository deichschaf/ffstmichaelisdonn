<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CriticalMessageLoader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'criticalreader:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Holt alle Warnungsnachrichten vom Bund';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
