<?php

/**
 * Created by PhpStorm.
 * User: Jörg
 * Date: 13.04.2015
 * Time: 17:13
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Bilderverzeichnis
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $cms_bilderverzeichnis_id
 * @property string $cms_bilder_jahr
 * @property string $cms_bilder_datum
 * @property string $cms_bilder_veranstaltung
 * @property string $cms_bilder_verzeichnis
 * @property string $cms_erstellt_am
 * @property string $cms_erstellt_von
 * @property string $cms_wasserzeichen
 * @property string $cms_bilder_extern
 * @property string $fotograf
 * @property string $erwachsende
 * @property string $jugendliche
 * @property string $cms_bilder_verzeichnis_beschreibung
 * @property string $bilder_datum
 * @property string $bilder_veranstaltung
 * @property string $bilder_verzeichnis
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereCmsBilderverzeichnisId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereCmsBilderJahr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereCmsBilderDatum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereCmsBilderVeranstaltung($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereCmsBilderVerzeichnis($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereCmsErstelltAm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereCmsErstelltVon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereCmsWasserzeichen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereCmsBilderExtern($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereFotograf($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereErwachsende($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereJugendliche($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereCmsBilderVerzeichnisBeschreibung($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereBilderDatum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereBilderVeranstaltung($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereBilderVerzeichnis($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereUpdatedAt($value)
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Bilderverzeichnis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Bilderverzeichnis newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Bilderverzeichnis query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilderverzeichnis withoutTrashed()
 */
class Bilderverzeichnis extends Model
{
    use SoftDeletes;

    protected $table = 'cms_bilderverzeichnis';
    protected $dates = ['deleted_at'];
}
