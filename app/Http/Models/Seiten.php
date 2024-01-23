<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Seiten
 *
 * @mixin Eloquent
 * @property integer $id
 * @property string $navi_title
 * @property string $title
 * @property string $page
 * @property string $laravel_route
 * @property string $pagetext
 * @property integer $parent_id
 * @property integer $pos
 * @property string $systempage
 * @property string $modul
 * @property string $link
 * @property string $navi_links
 * @property string $navi_top
 * @property string $erstellt_am
 * @property string $erstellt_von
 * @property string $geaendert_am
 * @property string $geaendert_von
 * @property string $show_titel
 * @property string $aktiv
 * @property string $show_datum_von
 * @property string $show_datum_bis
 * @property string $link_target
 * @property string $include_url
 * @property string $info_bild
 * @property string $info_text
 * @property string $show_navigation
 * @property string $kopf_grafik
 * @property string $show_infos
 * @property string $show_intern
 * @property string $kontaktemail
 * @property string $bereich_termine
 * @property string $bereich_news
 * @property string $bereich
 * @property string $loeschbar
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|Seiten whereId($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereNaviTitle($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten wherePage($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereLaravelRoute($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereSeitentext($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten wherePos($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereSystempage($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereModul($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereNaviLinks($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereNaviTop($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereErstelltAm($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereErstelltVon($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereGeaendertAm($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereGeaendertVon($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereShowTitel($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereAktiv($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereShowDatumVon($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereShowDatumBis($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereLinkTarget($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereIncludeUrl($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereInfoBild($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereInfoText($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereShowNavigation($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereKopfGrafik($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereShowInfos($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereShowIntern($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereKontaktemail($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereBereichTermine($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereBereichNews($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereBereich($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereLoeschbar($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten whereUpdatedAt($value)
 * @property Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Seiten whereDeletedAt($value)
 * @property int $page_id
 * @method static bool|null forceDelete()
 * @method static Builder|Seiten newModelQuery()
 * @method static Builder|Seiten newQuery()
 * @method static \Illuminate\Database\Query\Builder|Seiten onlyTrashed()
 * @method static Builder|Seiten query()
 * @method static bool|null restore()
 * @method static Builder|Seiten wherePageId($value)
 * @method static \Illuminate\Database\Query\Builder|Seiten withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Seiten withoutTrashed()
 * @property int $seiten_content_type
 * @property string $pagecontenttype
 * @property string $no_content_back
 * @method static Builder|Seiten whereNoContentBack($value)
 * @method static Builder|Seiten wherePagecontenttype($value)
 * @method static Builder|Seiten whereSeitenContentType($value)
 */
class Seiten extends Model
{
    use SoftDeletes;

    protected $table = 'cms_seiten';
    protected $dates = ['deleted_at'];
}
