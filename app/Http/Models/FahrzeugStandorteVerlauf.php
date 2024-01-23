<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\FahrzeugStandorteVerlauf
 *
 * @property int $cms_fahrzeug_standorte_verlauf_id
 * @property int $cms_fahrzeug_standorte_verlaufkarte_id
 * @property string $von
 * @property string $bis
 * @property string $fahrzeug_id
 * @property string $funkrufnamen
 * @property string $kennzeichen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf newQuery()
 * @method static \Illuminate\Database\Query\Builder|FahrzeugStandorteVerlauf onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf whereBis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf whereCmsFahrzeugStandorteVerlaufId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf whereCmsFahrzeugStandorteVerlaufkarteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf whereFahrzeugId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf whereFunkrufnamen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf whereKennzeichen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlauf whereVon($value)
 * @method static \Illuminate\Database\Query\Builder|FahrzeugStandorteVerlauf withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FahrzeugStandorteVerlauf withoutTrashed()
 * @mixin Eloquent
 */
class FahrzeugStandorteVerlauf extends Model
{
    use SoftDeletes;

    protected $table = 'cms_fahrzeug_standorte_verlauf';
    protected $dates = ['deleted_at'];
}
