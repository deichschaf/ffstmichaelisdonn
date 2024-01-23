<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Mail\ProbealarmMailer;
use Illuminate\Support\Facades\Mail;

class Probealarm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'probealarm:senden';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wöchentlicher Probelarmmailer';

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
        $mailer = new ProbealarmMailer();
        Mail::mailer('smtp_2')
            ->to('einsatzfax_datenmail@ff-st-michel.de')
            ->cc('j-mh@j-mh.de')
            ->send($mailer);
    }
}
