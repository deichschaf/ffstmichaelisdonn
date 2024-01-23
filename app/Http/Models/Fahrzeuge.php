<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Fahrzeuge
 *
 * @property int $id
 * @property string $fahrzeug
 * @property string $allgemein
 * @property string $kennzeichen
 * @property string $bos_kennung
 * @property string $zugelassen
 * @property string $motorleistung
 * @property string $fahrgestell
 * @property string $zulaessiges_gesamtgewicht
 * @property string $aufbau
 * @property string $ausfahrhoehe
 * @property string $sitzplaetze
 * @property string|null $tank
 * @property string $beladung_ueber_normal
 * @property string $besonderheiten
 * @property string $ausrangiert
 * @property string $erstellt_am
 * @property string|null $geaendert_von
 * @property string $geaendert_am
 * @property string $last_upload
 * @property int $cms_fahrzeug_ort_id
 * @property string $status_dienst
 * @property string $funkorganisation
 * @property string $verwendung
 * @property int $verwendung_id
 * @property string $baujahr
 * @property string $beschreibungstext
 * @property string $last_update
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Fahrzeuge onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereAllgemein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereAufbau($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereAusfahrhoehe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereAusrangiert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereBaujahr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereBeladungUeberNormal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereBeschreibungstext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereBesonderheiten($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereBosKennung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereCmsFahrzeugOrtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereErstelltAm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereFahrgestell($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereFahrzeug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereFunkorganisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereGeaendertAm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereGeaendertVon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereKennzeichen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereLastUpload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereMotorleistung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereSitzplaetze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereStatusDienst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereTank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereVerwendung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereVerwendungId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereZugelassen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Fahrzeuge whereZulaessigesGesamtgewicht($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Fahrzeuge withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Fahrzeuge withoutTrashed()
 * @mixin \Eloquent
 * @property string $bild
 * @property string|null $erstellt_von
 * @method static \Illuminate\Database\Eloquent\Builder|Fahrzeuge whereBild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fahrzeuge whereErstelltVon($value)
 */
class Fahrzeuge extends Model
{
    use SoftDeletes;

    protected $table = 'cms_fahrzeug';
    protected $dates = ['deleted_at'];
}
