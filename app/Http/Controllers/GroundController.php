<?php

namespace App\Http\Controllers;

use App\Http\Traits\AdminTrait;
use App\Http\Traits\BlackdayTrait;
use App\Http\Traits\BloodDonationTrait;
use App\Http\Traits\ChangeLogTrait;
use App\Http\Traits\CriticalTrait;
use App\Http\Traits\EinsaetzeTrait;
use App\Http\Traits\EloquentDatabaseTrait;
use App\Http\Traits\EmergencyStatisticTrait;
use App\Http\Traits\FeuerwehrTrait;
use App\Http\Traits\FxToolsCacheTrait;
use App\Http\Traits\FxToolsCheckProgsTrait;
use App\Http\Traits\FxToolsFilesTrait;
use App\Http\Traits\FxToolsStatusTrait;
use App\Http\Traits\FxToolsTimeTrait;
use App\Http\Traits\FxToolsTrait;
use App\Http\Traits\HeaderTrait;
use App\Http\Traits\HolidayTrait;
use App\Http\Traits\ImageTrait;
use App\Http\Traits\LayoutTrait;
use App\Http\Traits\LinksHelperTrait;
use App\Http\Traits\LinksTrait;
use App\Http\Traits\LoggerTrait;
use App\Http\Traits\MetatagsTrait;
use App\Http\Traits\MitgliederTrait;
use App\Http\Traits\NavigationTrait;
use App\Http\Traits\NewsTrait;
use App\Http\Traits\PageDataTrait;
use App\Http\Traits\PageTrait;
use App\Http\Traits\PartnerTrait;
use App\Http\Traits\PictureTrait;
use App\Http\Traits\SitemapTrait;
use App\Http\Traits\StartpageTrait;
use App\Http\Traits\TermineTrait;
use App\Http\Traits\TodoTrait;
use App\Http\Traits\VehiclesTrait;
use App\Http\Traits\WeatherTrait;
use App\Http\Traits\WidgetTrait;
use Illuminate\Support\Facades\DB;

class GroundController extends Controller
{
    use PictureTrait;
    use LoggerTrait;
    use EloquentDatabaseTrait;
    use VehiclesTrait;
    use CriticalTrait;
    use EinsaetzeTrait;
    use EmergencyStatisticTrait;
    use FxToolsTimeTrait;
    use FeuerwehrTrait;
    use SitemapTrait;
    use PartnerTrait;
    use LinksTrait;
    use TermineTrait;
    use LayoutTrait;
    use FxToolsTrait;
    use FxToolsCacheTrait;
    use FxToolsCheckProgsTrait;
    use FxToolsStatusTrait;
    use HeaderTrait;
    use MetatagsTrait;
    use MitgliederTrait;
    use NavigationTrait;
    use NewsTrait;
    use WidgetTrait;
    use ImageTrait;
    use BlackdayTrait;
    use PageTrait;
    use PageDataTrait;
    use AdminTrait;
    use ChangeLogTrait;
    use TodoTrait;
    use WeatherTrait;
    use HolidayTrait;
    use LinksHelperTrait;
    use StartpageTrait;
    use BloodDonationTrait;
    use FxToolsFilesTrait;
    use FxToolsTrait;

    /**
     * @return string
     */
    public function getAdminPath(): string
    {
        return '/admin';
    }

    public function clearPageCache()
    {
        $p = new PageController();
        $p->makeCacheClear(0);
    }

    /**
     * Startet das Loggin der DB Abfrage.
     */
    public function dbLogStart()
    {
        $log = DB::enableQueryLog();
    }

    /**
     * Endet das Loggin der DB Abfrage mit Check auf exit.
     *
     * @param bool $exit
     */
    public function dbLogEnd($exit = 0)
    {
        $query = DB::getQueryLog();
        $last_query = end($query);
        $this->debug($last_query, $exit);
    }

    /**
     * Debugger für schnelle Ausgabe.
     *
     * @param $val Mixed
     * @param bool $exit
     */
    public function debug($val, $exit = 0)
    {
        echo '<pre>';
        print_r($val);
        echo '</pre>';
        if (1 === $exit) {
            exit();
        }
    }

    public function arraySortByColumn($arr, $col, $dir = SORT_ASC): array
    {
        $sort_col = [];
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }
        array_multisort($sort_col, $dir, $arr);
        return $arr;
    }

    public function textRepInput($txt): string
    {
        $txt = str_replace('<br />', "\n", $txt);
        $txt = str_replace('<br/>', "\n", $txt);
        $txt = str_replace('<br>', "\n", $txt);

        return $txt;
    }

    public function textRepHtml($txt): string
    {
        $txt = nl2br($txt);

        return $txt;
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = view($this->layout);
        }
    }
}
