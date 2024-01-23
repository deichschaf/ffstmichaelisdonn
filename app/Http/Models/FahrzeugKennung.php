<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\FahrzeugKennung
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugKennung newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugKennung newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\FahrzeugKennung onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugKennung query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\FahrzeugKennung withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\FahrzeugKennung withoutTrashed()
 * @mixin \Eloquent
 * @property int $fahrzeugkennung_id
 * @property int|null $fahrzeug_id
 * @property string|null $fahrzeug_typ
 * @property string|null $von
 * @property string|null $bis
 * @property string|null $aktiv
 * @property string|null $fahrzeugkennung
 * @property string|null $florian
 * @property string|null $kater
 * @property string|null $heros
 * @property string|null $rotkreuz
 * @property string|null $kreis
 * @property string|null $rettung
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereAktiv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereBis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereFahrzeugId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereFahrzeugTyp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereFahrzeugkennung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereFahrzeugkennungId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereFlorian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereHeros($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereKater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereKreis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereRettung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereRotkreuz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugKennung whereVon($value)
 */
class FahrzeugKennung extends Model
{
    use SoftDeletes;

    protected $table = 'cms_fahrzeugkennung';
    protected $dates = ['deleted_at'];
}
