<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Traits\BloodDonationTrait;

class BloodDonationTermine extends Command
{
    protected $signature ='blutspende:termine';
    protected $description ='Holt Blutspendetermine vom DRK';
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        BloodDonationTrait::setBloodDonationTermineCron();
    }
}
