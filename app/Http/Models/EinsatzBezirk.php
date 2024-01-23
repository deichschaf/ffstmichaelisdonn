<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\EinsatzBezirk
 *
 * @property int $id
 * @property string $primaer
 * @property string|null $bezirk
 * @property string|null $name
 * @property string|null $lat
 * @property string|null $lng
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk newQuery()
 * @method static \Illuminate\Database\Query\Builder|EinsatzBezirk onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk query()
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk whereBezirk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk wherePrimaer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBezirk whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EinsatzBezirk withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EinsatzBezirk withoutTrashed()
 * @mixin \Eloquent
 */
class EinsatzBezirk extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_einsaetze_bezirk';
}
