<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Mitglieder
 *
 * @property int $id
 * @property string|null $vorname
 * @property string|null $nachname
 * @property string|null $dienstgrad
 * @property string|null $strasse
 * @property string|null $plz
 * @property string|null $ort
 * @property string|null $telefon
 * @property string|null $telefon2
 * @property string|null $dienstlich
 * @property string|null $mobil
 * @property string|null $telefax
 * @property string|null $emailadresse
 * @property string|null $emailadresse2
 * @property string|null $bild
 * @property string|null $geburtstag
 * @property string|null $geburtsort
 * @property string|null $benutzer
 * @property string|null $passwort
 * @property string $sichtbar
 * @property string $sichtbar_strasse
 * @property string $sichtbar_plz
 * @property string $sichtbar_ort
 * @property string $sichtbar_telefon
 * @property string $sichtbar_telefon2
 * @property string $sichtbar_telefax
 * @property string $sichtbar_mobil
 * @property string $sichtbar_email
 * @property string $sichtbar_geburtstag
 * @property string $altgedienter
 * @property string|null $ausgeschieden
 * @property string|null $icq
 * @property string|null $skype
 * @property string|null $unfallnachricht
 * @property string $at_traeger
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder newQuery()
 * @method static \Illuminate\Database\Query\Builder|Mitglieder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereAltgedienter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereAtTraeger($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereAusgeschieden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereBenutzer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereBild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereDienstgrad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereDienstlich($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereEmailadresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereEmailadresse2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereGeburtsort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereGeburtstag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereIcq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereMobil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereNachname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereOrt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder wherePasswort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder wherePlz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereSichtbar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereSichtbarEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereSichtbarGeburtstag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereSichtbarMobil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereSichtbarOrt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereSichtbarPlz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereSichtbarStrasse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereSichtbarTelefax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereSichtbarTelefon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereSichtbarTelefon2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereSkype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereStrasse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereTelefax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereTelefon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereTelefon2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereUnfallnachricht($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mitglieder whereVorname($value)
 * @method static \Illuminate\Database\Query\Builder|Mitglieder withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Mitglieder withoutTrashed()
 * @mixin \Eloquent
 */
class Mitglieder extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_mitglieder';
}
