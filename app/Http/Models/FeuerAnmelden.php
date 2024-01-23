<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\FeuerAnmelden
 *
 * @property int $id
 * @property string|null $datum
 * @property string|null $uhrzeit
 * @property string|null $nachname
 * @property string|null $vorname
 * @property string|null $strasse
 * @property string|null $plz
 * @property string|null $wohnort
 * @property string|null $telefon
 * @property string|null $emailadresse
 * @property string|null $feuer_strasse
 * @property string|null $feuer_plz
 * @property string|null $feuer_ort
 * @property string|null $bemerkung
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden newQuery()
 * @method static Builder|FeuerAnmelden onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden query()
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereBemerkung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereDatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereEmailadresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereFeuerOrt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereFeuerPlz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereFeuerStrasse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereNachname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden wherePlz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereStrasse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereTelefon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereUhrzeit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereVorname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerAnmelden whereWohnort($value)
 * @method static Builder|FeuerAnmelden withTrashed()
 * @method static Builder|FeuerAnmelden withoutTrashed()
 * @mixin Eloquent
 */
class FeuerAnmelden extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_feuer_anmelden';
}
