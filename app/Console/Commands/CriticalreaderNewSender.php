<?php

namespace App\Console\Commands;

use App\Http\Traits\ModDwdwetterHelperTrait;
use Illuminate\Console\Command;

class CriticalreaderNewSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'criticalreader:newsender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Holt alle Nachrichten vom Bund Nina';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ModDwdwetterHelperTrait::AddNewCriticalSender();
    }
}
