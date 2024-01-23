<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Termine
 *
 * @property int $cms_termine_id
 * @property string $datum
 * @property string $datum_von
 * @property string $datum_bis
 * @property string $uhrzeit_von
 * @property string $uhrzeit_bis
 * @property string $ort
 * @property string $veranstaltungsort
 * @property string $veranstaltung
 * @property string $beschreibung
 * @property string $veranstalter
 * @property string $kosten
 * @property string $anmeldung
 * @property string $highlight
 * @property string $startseite
 * @property string $landesweit
 * @property string $anmeldung_erforderlich
 * @property string $abfahrt
 * @property string $kleidung
 * @property string $pflicht
 * @property string $aktiv
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Termine onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereAbfahrt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereAktiv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereAnmeldung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereAnmeldungErforderlich($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereBeschreibung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereCmsTermineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereDatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereDatumBis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereDatumVon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereHighlight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereKleidung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereKosten($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereLandesweit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereOrt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine wherePflicht($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereStartseite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereUhrzeitBis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereUhrzeitVon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereVeranstalter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereVeranstaltung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Termine whereVeranstaltungsort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Termine withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Termine withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $beginn
 * @property string $bis
 * @property string|null $termin
 * @property string|null $zeichen
 * @property string $is_public
 * @method static \Illuminate\Database\Eloquent\Builder|Termine whereBeginn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Termine whereBis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Termine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Termine whereis_public($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Termine whereTermin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Termine whereZeichen($value)
 */
class Termine extends Model
{
    use SoftDeletes;

    protected $table = 'cms_termine';
    protected $dates = ['deleted_at'];
}
