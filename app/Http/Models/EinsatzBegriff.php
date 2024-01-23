<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\EinsatzBegriff
 *
 * @property int $id
 * @property string $begriff
 * @property string $kurz
 * @property string $feuer
 * @property string $thl
 * @property string $heumessung
 * @property string $fehlalarm
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff newQuery()
 * @method static \Illuminate\Database\Query\Builder|EinsatzBegriff onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff query()
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff whereBegriff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff whereFehlalarm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff whereFeuer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff whereHeumessung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff whereKurz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff whereThl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzBegriff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EinsatzBegriff withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EinsatzBegriff withoutTrashed()
 * @mixin \Eloquent
 */
class EinsatzBegriff extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_einsatz_begriffe';
}
