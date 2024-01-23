<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\FahrzeugTypen
 *
 * @property int $cms_fahrzeug_typ_id
 * @property string $typ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugTypen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugTypen newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\FahrzeugTypen onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugTypen query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugTypen whereCmsFahrzeugTypId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugTypen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugTypen whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugTypen whereTyp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\FahrzeugTypen whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\FahrzeugTypen withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\FahrzeugTypen withoutTrashed()
 * @mixin \Eloquent
 */
class FahrzeugTypen extends Model
{
    use SoftDeletes;

    protected $table = 'cms_fahrzeug_typen';
    protected $dates = ['deleted_at'];
}
