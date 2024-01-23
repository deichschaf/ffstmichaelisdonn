<?php

namespace App\Http\Traits;

use App\Http\Models\Seiten;
use App\Http\Models\SeitenContentTypes;
use App\Http\Models\SeitenHeadImages;
use App\Http\Models\SeitenTexte;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * Trait PageTrait
 * @package App\Http\Traits
 */
trait PageTrait
{
    /**
     * @param $search
     * @param $nopublic
     * @param $searchcontent
     * @return mixed
     */
    public static function getStaticSearchPage($search, $nopublic, $searchcontent)
    {
        $data = [];
        if ($nopublic === 1) {
            $Pages = Seiten::where('page', '!=', '')
                ->where('aktiv', '=', '1')
                ->where('pagetext', 'LIKE', '%' . $search . '%')
                ->get();
        } else {
            $Pages = Seiten::where('page', '!=', '')
                ->where('show_navigation', '=', '1')
                ->where('aktiv', '=', '1')
                ->where(
                    'pagetext',
                    'LIKE',
                    '%' . $search . '%'
                )
                ->get();
        }

        if (count($Pages) === 0) {
            return $searchcontent;
        }
        $Pages->each(function ($p) use (&$searchcontent) {
            $searchcontent[] = [
                'title' => $p->title,
                'route' => $p->page,
                'content' => $p->pagetext
            ];
        });
        return $searchcontent;
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public static function DelPage($id)
    {
        $page = Seiten::where('id', '=', $id)->delete();
        return true;
    }

    /**
     * @param $inputs
     * @return string
     */
    public static function SavePage($inputs)
    {
        $save = Seiten::find($inputs['id']);
        $save->title = $inputs['title'];
        $save->navi_title = $inputs['navi_title'];
        $save->pagetext = FxToolsTrait::makeWysiwygReplaceStatic($inputs['pagetext']);
        $save->link = $inputs['link'];
        $save->link_target = $inputs['link_target'];
        $save->save();

        $id = 0;
        $SeitenHeadImage = SeitenHeadImages::where('page_id', '=', $inputs['id'])->get();
        $SeitenHeadImage->each(function ($SHI) use (&$id) {
            $id = $SHI->id;
        });
        if ($id > 0) {
            $save = SeitenHeadImages::find($id);
            $save->headerimage_id = $inputs['head_image'];
            $save->save();
        } else {
            $save = new SeitenHeadImages();
            $save->page_id = $inputs['id'];
            $save->headerimage_id = $inputs['head_image'];
            $save->save();
        }
        return '';
    }

    /**
     * @param $inputs
     * @return string
     */
    public static function SavePageHeadline($inputs)
    {
        $save = Seiten::find($inputs['id']);
        $save->title = $inputs['title'];
        $save->navi_title = $inputs['navi_title'];
        $save->save();
        return '';
    }

    /**
     * @param int $parent_id
     * @return array
     */
    public function getListPages(int $parent_id = 0): array
    {
        return self::getStaticPages($parent_id);
    }

    /**
     * @param int $parent_id
     * @return array
     */
    public static function getStaticPages($parent_id = 0)
    {
        $data = [];
        $Pages = Seiten::where('parent_id', '=', $parent_id)
            ->orderBy('parent_id', 'ASC')
            ->orderBy('pos', 'ASC')
            ->get();
        $Pages->each(function ($p) use (&$data) {
            $data[] = [
                'page' => $p,
                'upage' => self::getStaticPages($p->id)
            ];
        });
        return $data;
    }

    public function getContactPlaceholder(): array
    {
        $placeholder = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $PlaceholderKeys = SeitenTexte::where('is_contact', '=', '1')->get();
                $PlaceholderKeys->each(function ($st) use (&$data) {

                    if ($st->placeholder_name === '[NEXTYEAR]') {
                        $data[$this->makePlaceholderKey($st->placeholder_name)] = date("Y") + 1;
                    } elseif ($st->placeholder_name === '[THISYEAR]') {
                        $data[$this->makePlaceholderKey($st->placeholder_name)] = date("Y");
                    } else {
                        $data[$this->makePlaceholderKey($st->placeholder_name)] = $st->placeholder_text;
                    }
                });
                return $data;
            }
        );
        return $placeholder;
    }

    private function makePlaceholderKey(string $key = ''): string
    {
        $newkey = str_replace(array('[', ']'), '', $key);
        return strtolower($newkey);
    }

    /**
     * @return array
     */
    public function getPlaceholderAdmin(): array
    {
        $data = [];
        $PlaceholderKeys = SeitenTexte::orderBy('placeholder_name', 'ASC')->get();
        $PlaceholderKeys->each(function ($st) use (&$data) {
            $data[] = [
                'id' => $st->id,
                'placeholder_name' => $st->placeholder_name,
                'placeholder_text' => $st->placeholder_text,
            ];
        });
        return $data;
    }

    /**
     * @param $id
     * @return array
     */
    public function getPage($id)
    {
        if ($id === 0) {
            return [];
        }
        $data = [];
        $Page = Seiten::where('id', '=', $id)->get();
        $Page->each(function ($p) use (&$data) {
            $data['id'] = $p->id;
            $data['navi_title'] = $this->ReplacePlaceholder($p->navi_title);
            $data['title'] = $this->ReplacePlaceholder($p->title);
            $data['page'] = $p->page;
            $data['pagetext'] = $this->ReplacePlaceholder($p->pagetext);
            $data['link'] = $p->link;
            $data['link_target'] = $p->link_target;
            $data['show_titel'] = $p->show_titel;
            $data['show_navigation'] = $p->show_navigation;
            $data['aktiv'] = $p->aktiv;
            $data['seiten_content_type'] = $p->seiten_content_type;
            $data['pagecontenttype'] = $p->seiten_content_type;
        });
        $data['head_image'] = 1;
        $PageHeadImage = SeitenHeadImages::where('id', '=', $id)->get();
        $PageHeadImage->each(function ($shi) use (&$data) {
            $data['head_image'] = $shi->headerimage_id;
        });
        return $data;
    }

    /**
     * @param string|null $content
     * @return string
     */
    public function ReplacePlaceholder(string|null $content): string
    {
        if (!is_string($content)) {
            return '';
        }
        $placeholder = $this->getPlaceholder();
        return $this->replaceTextPlaceholder($content, $placeholder);
    }

    /**
     * @return array
     */
    public function getPlaceholder(): array
    {
        $placeholder = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $PlaceholderKeys = SeitenTexte::get();
                $PlaceholderKeys->each(function ($st) use (&$data) {
                    if ($st->placeholder_name === '[NEXTYEAR]') {
                        $data[$st->placeholder_name] = date("Y") + 1;
                    } elseif ($st->placeholder_name === '[THISYEAR]') {
                        $data[$st->placeholder_name] = date("Y");
                    } else {
                        $data[$st->placeholder_name] = $st->placeholder_text;
                    }
                });
                return $data;
            }
        );
        return $placeholder;
    }

    /**
     * @param string $content
     * @param array $placeholder
     * @return string
     */
    public function replaceTextPlaceholder(string $content, array $placeholder): string
    {
        $content = $this->BBCodeReplace($content);
        foreach ($placeholder as $k => $val) {
            $content = str_replace($k, $val, $content);
        }
        $content = str_replace(array('<p>', '&#60;', '&#62;'), array('<p class="text">', '<', '<'), $content);
        return $content;
    }

    /**
     * @param $content
     * @return string
     */
    private function BBCodeReplace($content = ''): string
    {
        return $content;
    }

    /**
     * @return array
     */
    public function getPageContentTypes(): array
    {
        $content_types = [];
        $SeitenContentTypes = SeitenContentTypes::orderBy('id', 'ASC')->get();
        $SeitenContentTypes->each(function ($sct) use (&$content_types) {
            $content_types[$sct->id] = $sct;
        });
        return $content_types;
    }
}
