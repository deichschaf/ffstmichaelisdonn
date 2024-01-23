<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\Einsaetze
 *
 * @property int $einsatz_id
 * @property int $cms_einsatz_begriffe_id
 * @property string $loeschhilfe
 * @property string $einsatz_begin
 * @property string $einsatz_ende
 * @property string $einsatz_nummer
 * @property string $einsatz_ort
 * @property string $einsatz_art
 * @property string|null $einsatz_beschreibung
 * @property string|null $einsatz_fahrzeuge
 * @property string|null $einsatz_youtube
 * @property string $einsatz_typ
 * @property string $einsatz_erstellt_am
 * @property string $einsatz_erstellt_von
 * @property string $einsatz_geaendert_am
 * @property string $einsatz_geaendert_von
 * @property string $aktiv
 * @property string $bemerkung
 * @property string $alarmierung_wehrfuehrer
 * @property string $alarmierung_gruppenfuehrer
 * @property string $alarmierung_alle
 * @property int $einsatz_bilder
 * @property string $einsatz_ort_lon
 * @property string $einsatz_ort_lat
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static Builder|Einsaetze newModelQuery()
 * @method static Builder|Einsaetze newQuery()
 * @method static \Illuminate\Database\Query\Builder|Einsaetze onlyTrashed()
 * @method static Builder|Einsaetze query()
 * @method static bool|null restore()
 * @method static Builder|Einsaetze whereAktiv($value)
 * @method static Builder|Einsaetze whereAlarmierungAlle($value)
 * @method static Builder|Einsaetze whereAlarmierungGruppenfuehrer($value)
 * @method static Builder|Einsaetze whereAlarmierungWehrfuehrer($value)
 * @method static Builder|Einsaetze whereBemerkung($value)
 * @method static Builder|Einsaetze whereCmsEinsatzBegriffeId($value)
 * @method static Builder|Einsaetze whereCreatedAt($value)
 * @method static Builder|Einsaetze whereDeletedAt($value)
 * @method static Builder|Einsaetze whereEinsatzArt($value)
 * @method static Builder|Einsaetze whereEinsatzBegin($value)
 * @method static Builder|Einsaetze whereEinsatzBeschreibung($value)
 * @method static Builder|Einsaetze whereEinsatzBilder($value)
 * @method static Builder|Einsaetze whereEinsatzEnde($value)
 * @method static Builder|Einsaetze whereEinsatzErstelltAm($value)
 * @method static Builder|Einsaetze whereEinsatzErstelltVon($value)
 * @method static Builder|Einsaetze whereEinsatzFahrzeuge($value)
 * @method static Builder|Einsaetze whereEinsatzGeaendertAm($value)
 * @method static Builder|Einsaetze whereEinsatzGeaendertVon($value)
 * @method static Builder|Einsaetze whereEinsatzId($value)
 * @method static Builder|Einsaetze whereEinsatzNummer($value)
 * @method static Builder|Einsaetze whereEinsatzOrt($value)
 * @method static Builder|Einsaetze whereEinsatzOrtLat($value)
 * @method static Builder|Einsaetze whereEinsatzOrtLon($value)
 * @method static Builder|Einsaetze whereEinsatzTyp($value)
 * @method static Builder|Einsaetze whereEinsatzYoutube($value)
 * @method static Builder|Einsaetze whereLoeschhilfe($value)
 * @method static Builder|Einsaetze whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Einsaetze withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Einsaetze withoutTrashed()
 * @mixin Eloquent
 * @property int $id
 * @property string|null $einsatz_fahrzeuge_alarmierung
 * @property int|null $einsatz_bericht
 * @property string|null $pressetext
 * @property string|null $presse
 * @method static Builder|Einsaetze whereEinsatzBericht($value)
 * @method static Builder|Einsaetze whereEinsatzFahrzeugeAlarmierung($value)
 * @method static Builder|Einsaetze whereId($value)
 * @method static Builder|Einsaetze wherePresse($value)
 * @method static Builder|Einsaetze wherePressetext($value)
 */
class Einsaetze extends Model
{
    use SoftDeletes;

    protected $table = 'cms_einsaetze';
    protected $dates = ['deleted_at'];
}
