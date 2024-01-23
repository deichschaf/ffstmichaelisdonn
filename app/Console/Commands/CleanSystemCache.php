<?php

namespace App\Console\Commands;

use App\Http\Models\CacheModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CleanSystemCache extends Command
{
    protected $signature = 'cleansystemcache';
    public function handle()
    {
        CacheModel::where('value', '!=', '')->delete();
        Artisan::call('cache:clear');
        #Artisan::call('debugbar:clear');
        Artisan::call('view:clear');
        return Command::SUCCESS;
    }
}
