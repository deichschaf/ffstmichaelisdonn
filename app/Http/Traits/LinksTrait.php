<?php
namespace App\Http\Traits;

use App\Http\Models\Links;
use App\Http\Models\LinksKategorien;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait LinksTrait
{
    public function getAdminOverviewLinks():array
    {
        $kategorien = $this->getLinksKategorien();
        $links = [];
        foreach ($kategorien as $key => $val) {
            $Links = Links::where('link_kategorie_id', '=', $key)
                ->orderBy('link_titel', 'ASC')
                ->get();
            $Links->each(function ($l) use (&$links, $val) {
                $titel = $l->link_titel;
                $description = '';
                if ($l->link_text != '' && $l->link_text != null) {
                    $description= $l->link_text;
                }
                $link = $l->link;
                $links[] = [
                    'id'=>$l->id,
                    'url'=>$link,
                    'title'=>$titel,
                    'description'=>$description,
                    'category'=>$val,
                    'is_brocken'=>$l->is_brocken
                ];
            });
        }
        return $links;
    }

    /**
     * @return array
     */
    public function getLinks():array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $kategorien = $this->getLinksKategorien();
                $links = [];
                foreach ($kategorien as $key => $val) {
                    $links[] = ['category_title' => $val];
                    $Links = Links::where('link_kategorie_id', '=', $key)
                        ->orderBy('link_titel', 'ASC')
                        ->get();
                    $Links->each(function ($l) use (&$links) {
                        $titel = $l->link_titel;
                        $description = '';
                        if ($l->link_text != '' && $l->link_text != null) {
                            $description= $l->link_text;
                        }
                        $link = $l->link;
                        $links[] = [
                            'url'=>$link,
                            'title'=>$titel,
                            'description'=>$description,
                            'target' => '_blank',
                            'rel' => 'noopener noreferrer'
                        ];
                    });
                }
                return $links;
            }
        );
        return $data;
    }
    /**
     * @return array
     */
    public function getLinksKategorien()
    {
        $kategorien = [];
        $kategorien['0'] = 'Keine Kategorie';
        $Kategorien = LinksKategorien::orderBy('pos', 'ASC')
            ->orderBy('link_kategorie', 'ASC')
            ->get();
        $Kategorien->each(function ($k) use (&$kategorien) {
            $kategorien[$k->id] = $k->link_kategorie;
        });
        return $kategorien;
    }
}
