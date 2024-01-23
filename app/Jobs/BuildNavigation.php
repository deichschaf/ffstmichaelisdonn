<?php

namespace App\Jobs;

use App\Http\Traits\NavigationTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

/***
 * Class BuildNavigation
 * @package App\Jobs
 *
 * Generiert die Navigation für normale Homepagebesucher und speichert es als Template ab
 * Dadurch wird Generierungszeit vermieden und die Webseite lädt schneller
 * @todo Cronjob einrichten?!?
 * @todo Check nach Timestempel?
 * @todo Adminbereich beim Seiten aktivieren / deaktivieren laufen lassen
 */

class BuildNavigation extends Job implements ShouldQueue
{
    use InteractsWithQueue;
    use SerializesModels;
    use NavigationTrait;

    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct()
    {
    }

    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        $navigation = $this->getLeftNavi3(0);
        $mobilnavigation = $this->getMobileNavi(0);

        if ('' !== $navigation && '' !== $mobilnavigation) {
            $path = storage_path() . DIRECTORY_SEPARATOR . 'pagetemplates' . DIRECTORY_SEPARATOR;
            if (! is_dir($path)) {
                mkdir($path, 0777);
            }
            $this->writeContent($path . 'navigation.blade.php', $navigation);
            $this->writeContent($path . 'mobilenavigation.blade.php', $mobilnavigation);
        }
    }

    private function writeContent($file, $content)
    {
        try {
            $bytes_written = File::put($file, $content);
            if (false === $bytes_written) {
                exit('Error writing to file');
            }
        } catch (\Exception $e) {
            /***
            * @todo logging einbauen!!!
            */
        }
    }
}
