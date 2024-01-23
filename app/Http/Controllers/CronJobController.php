<?php

/**
 * Created by PhpStorm.
 * User: Jörg
 * Date: 02.10.2015
 * Time: 06:35
 */

namespace App\Http\Controllers;

use App\Http\Models\CronJob;
use App\Http\Models\CronJobLog;
use App\Http\Models\Mitglieder;

class CronJobController extends GroundController
{
    public function cron()
    {
        $cronjob = [];
        $CRON = CronJob::where('active', '=', '1')->get();
        $CRON->each(function ($cron) use (&$cronjob) {
            // Bsp: Geburtstagsmailer
            // Bsp: Newsletter
        });
    }

    /***
     * Geburtstagsmailer starten
     */
    public function cron_birthday()
    {
        $send = MitgliederController::Geburtstagsgruss();
        $cron = new CronJobLog();
        $cron->cron = 'Birthday';
        $cron->protocol = 'Send ' . $send;
        $cron->save();
    }

    public function cron_deltemp()
    {
        $path = storage_path();

        $this->delfiles('cache');
        $this->delfiles('sessions');
        $this->delfiles('views');
        \Cache::flush();

        $cron = new CronJobLog();
        $cron->cron = 'DELTemp';
        $cron->protocol = 'erfolgreich';
        $cron->save();
    }

    private function delfiles($path)
    {
        $cachedViewsDirectory = app('path.storage') . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
        $files = glob($cachedViewsDirectory . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
    }
}
