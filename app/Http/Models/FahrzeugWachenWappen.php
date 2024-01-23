<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\FahrzeugWachenWappen
 *
 * @property int $id
 * @property string $wappen
 * @property string $wache
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugWachenWappen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugWachenWappen newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\FahrzeugWachenWappen onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugWachenWappen query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugWachenWappen whereCmsFahrzeugWachenWappenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugWachenWappen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugWachenWappen whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugWachenWappen whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugWachenWappen whereWache($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugWachenWappen whereWappen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\FahrzeugWachenWappen withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\FahrzeugWachenWappen withoutTrashed()
 * @mixin \Eloquent
 */
class FahrzeugWachenWappen extends Model
{
    use SoftDeletes;

    protected $table = 'cms_fahrzeug_wachen_wappen';
    protected $dates = ['deleted_at'];
}
