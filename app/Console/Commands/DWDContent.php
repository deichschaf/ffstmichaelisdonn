<?php

namespace App\Console\Commands;

use App\Http\Traits\ModDwdwetterHelperTrait;
use Illuminate\Console\Command;

class DWDContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dwd:content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Holt alle Nachrichten vom DWD';

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
        ModDwdwetterHelperTrait::GetDWDFTP();
    }
}
