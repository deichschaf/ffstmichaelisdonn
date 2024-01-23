<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\Feuerwehren
 *
 * @property int $cms_feuerwehr_id
 * @property string $feuerwehr
 * @property string $strasse
 * @property string $plz
 * @property string $ort
 * @property string $telefon
 * @property string $telefax
 * @property string $emailadresse
 * @property string $homepage
 * @property string $wehrfuehrer
 * @property string $freiwillige
 * @property string $pflichtwehr
 * @property string $werkfeuerwehr
 * @property string $wachenbild
 * @property string $gruppenfoto
 * @property string $gruppenfoto_text
 * @property string $jugendgruppenfoto
 * @property string $jugendgruppenfoto_text
 * @property string $aktualisiert
 * @property float $geo_l
 * @property float $geo_b
 * @property string $is_feuerwehr
 * @property string $is_rkish
 * @property string $is_drk
 * @property string $is_thw
 * @property string $is_dgzrs
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static Builder|Feuerwehren newModelQuery()
 * @method static Builder|Feuerwehren newQuery()
 * @method static \Illuminate\Database\Query\Builder|Feuerwehren onlyTrashed()
 * @method static Builder|Feuerwehren query()
 * @method static bool|null restore()
 * @method static Builder|Feuerwehren whereAktualisiert($value)
 * @method static Builder|Feuerwehren whereCmsFeuerwehrId($value)
 * @method static Builder|Feuerwehren whereCreatedAt($value)
 * @method static Builder|Feuerwehren whereDeletedAt($value)
 * @method static Builder|Feuerwehren whereEmailadresse($value)
 * @method static Builder|Feuerwehren whereFeuerwehr($value)
 * @method static Builder|Feuerwehren whereFreiwillige($value)
 * @method static Builder|Feuerwehren whereGeoB($value)
 * @method static Builder|Feuerwehren whereGeoL($value)
 * @method static Builder|Feuerwehren whereGruppenfoto($value)
 * @method static Builder|Feuerwehren whereGruppenfotoText($value)
 * @method static Builder|Feuerwehren whereHomepage($value)
 * @method static Builder|Feuerwehren whereIsDgzrs($value)
 * @method static Builder|Feuerwehren whereIsDrk($value)
 * @method static Builder|Feuerwehren whereIsFeuerwehr($value)
 * @method static Builder|Feuerwehren whereIsRkish($value)
 * @method static Builder|Feuerwehren whereIsThw($value)
 * @method static Builder|Feuerwehren whereJugendgruppenfoto($value)
 * @method static Builder|Feuerwehren whereJugendgruppenfotoText($value)
 * @method static Builder|Feuerwehren whereOrt($value)
 * @method static Builder|Feuerwehren wherePflichtwehr($value)
 * @method static Builder|Feuerwehren wherePlz($value)
 * @method static Builder|Feuerwehren whereStrasse($value)
 * @method static Builder|Feuerwehren whereTelefax($value)
 * @method static Builder|Feuerwehren whereTelefon($value)
 * @method static Builder|Feuerwehren whereUpdatedAt($value)
 * @method static Builder|Feuerwehren whereWachenbild($value)
 * @method static Builder|Feuerwehren whereWehrfuehrer($value)
 * @method static Builder|Feuerwehren whereWerkfeuerwehr($value)
 * @method static \Illuminate\Database\Query\Builder|Feuerwehren withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Feuerwehren withoutTrashed()
 * @mixin Eloquent
 * @property int $id
 * @method static Builder|Feuerwehren whereId($value)
 */
class Feuerwehren extends Model
{
    use SoftDeletes;

    protected $table = 'cms_feuerwehren';
    protected $dates = ['deleted_at'];
}
