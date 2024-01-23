<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Wachen
 *
 * @property int $id
 * @property string|null $einheit
 * @property string|null $hiort_name
 * @property string|null $strasse
 * @property string|null $plz
 * @property string|null $ort
 * @property string|null $gemeinde
 * @property string|null $gemeinde_abc
 * @property string|null $amt
 * @property string|null $telefon
 * @property string|null $telefax
 * @property string|null $emailadresse
 * @property string|null $homepage
 * @property string|null $wehrfuehrer
 * @property string $freiwillige
 * @property string $pflichtwehr
 * @property string $werkfeuerwehr
 * @property string|null $wachenbild
 * @property string|null $aktualisiert
 * @property float|null $geo_l
 * @property float|null $geo_b
 * @property int|null $xkoordinate
 * @property int|null $ykoordinate
 * @property string $is_feuerwehr
 * @property string $is_rkish
 * @property string $is_drk
 * @property string $is_thw
 * @property string $is_dgzrs
 * @property string|null $hiorg
 * @property string|null $beschreibung
 * @property string|null $bezeichnung
 * @property int $wappen_id
 * @property string|null $wachentyp
 * @property string|null $funkrufnamen
 * @property string|null $standort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wachen onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereAktualisiert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereAmt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereBeschreibung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereBezeichnung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereEinheit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereEmailadresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereFreiwillige($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereFunkrufnamen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereGemeinde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereGemeindeAbc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereGeoB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereGeoL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereHiorg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereHiortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereHomepage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereIsDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereIsDgzrs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereIsDrk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereIsFeuerwehr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereIsRkish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereIsThw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereOrt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen wherePflichtwehr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen wherePlz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereStandort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereStrasse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereTelefax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereTelefon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereWachenbild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereWachentyp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereWappenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereWehrfuehrer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereWerkfeuerwehr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereXkoordinate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wachen whereYkoordinate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wachen withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wachen withoutTrashed()
 * @mixin \Eloquent
 */
class Wachen extends Model
{
    use SoftDeletes;

    protected $table = 'cms_fahrzeug_wachen';
    protected $dates = ['deleted_at'];
}
