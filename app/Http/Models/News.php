<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\News
 *
 * @mixin Eloquent
 * @property integer $id
 * @property string $titel
 * @property string $untertitel
 * @property string $artikel
 * @property string $datum_zeit
 * @property integer $tel_cms_news_quelle_id
 * @property string $link
 * @property string $bild
 * @property string $bildunterschrift
 * @property string $archiv
 * @property string $erstellt_am
 * @property string $erstellt_von
 * @property string $geaendert_am
 * @property string $geaendert_von
 * @property integer $cms_news_quelle_id
 * @property string $quelle
 * @property integer $news_id
 * @property string $news_titel
 * @property string $news_kurz
 * @property string $news_lang
 * @property string $news_link
 * @property string $news_datum
 * @property string $news_geaendert
 * @property string $datum
 * @property string $ueberschrift
 * @property string $unterzeile
 * @property string $news_text
 * @property string $vorspan_ueberschrift
 * @property string $vorspan
 * @property string $aktiv
 * @property string $highlight
 * @property string $startseite
 * @property integer $cms_seiten_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|News whereId($value)
 * @method static \Illuminate\Database\Query\Builder|News whereTitel($value)
 * @method static \Illuminate\Database\Query\Builder|News whereUntertitel($value)
 * @method static \Illuminate\Database\Query\Builder|News whereArtikel($value)
 * @method static \Illuminate\Database\Query\Builder|News whereDatumZeit($value)
 * @method static \Illuminate\Database\Query\Builder|News whereTelCmsNewsQuelleId($value)
 * @method static \Illuminate\Database\Query\Builder|News whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|News whereBild($value)
 * @method static \Illuminate\Database\Query\Builder|News whereBildunterschrift($value)
 * @method static \Illuminate\Database\Query\Builder|News whereArchiv($value)
 * @method static \Illuminate\Database\Query\Builder|News whereErstelltAm($value)
 * @method static \Illuminate\Database\Query\Builder|News whereErstelltVon($value)
 * @method static \Illuminate\Database\Query\Builder|News whereGeaendertAm($value)
 * @method static \Illuminate\Database\Query\Builder|News whereGeaendertVon($value)
 * @method static \Illuminate\Database\Query\Builder|News whereCmsNewsQuelleId($value)
 * @method static \Illuminate\Database\Query\Builder|News whereQuelle($value)
 * @method static \Illuminate\Database\Query\Builder|News whereNewsId($value)
 * @method static \Illuminate\Database\Query\Builder|News whereNewsTitel($value)
 * @method static \Illuminate\Database\Query\Builder|News whereNewsKurz($value)
 * @method static \Illuminate\Database\Query\Builder|News whereNewsLang($value)
 * @method static \Illuminate\Database\Query\Builder|News whereNewsLink($value)
 * @method static \Illuminate\Database\Query\Builder|News whereNewsDatum($value)
 * @method static \Illuminate\Database\Query\Builder|News whereNewsGeaendert($value)
 * @method static \Illuminate\Database\Query\Builder|News whereDatum($value)
 * @method static \Illuminate\Database\Query\Builder|News whereUeberschrift($value)
 * @method static \Illuminate\Database\Query\Builder|News whereUnterzeile($value)
 * @method static \Illuminate\Database\Query\Builder|News whereNewsText($value)
 * @method static \Illuminate\Database\Query\Builder|News whereVorspanUeberschrift($value)
 * @method static \Illuminate\Database\Query\Builder|News whereVorspan($value)
 * @method static \Illuminate\Database\Query\Builder|News whereAktiv($value)
 * @method static \Illuminate\Database\Query\Builder|News whereHighlight($value)
 * @method static \Illuminate\Database\Query\Builder|News whereStartseite($value)
 * @method static \Illuminate\Database\Query\Builder|News whereCmsSeitenId($value)
 * @method static \Illuminate\Database\Query\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|News whereUpdatedAt($value)
 * @property Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|News whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static Builder|News newModelQuery()
 * @method static Builder|News newQuery()
 * @method static \Illuminate\Database\Query\Builder|News onlyTrashed()
 * @method static Builder|News query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|News withTrashed()
 * @method static \Illuminate\Database\Query\Builder|News withoutTrashed()
 * @property string $anzeigen_bis
 * @method static Builder|News whereAnzeigenBis($value)
 */
class News extends Model
{
    use SoftDeletes;

    protected $table = 'cms_news';
    protected $dates = ['deleted_at'];
}
