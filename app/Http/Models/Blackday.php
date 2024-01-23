<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Blackday
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Blackday newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Blackday newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Blackday onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Blackday query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Blackday withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Blackday withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $blackday
 * @property string $datum_von
 * @property string $datum_bis
 * @property string $title
 * @property string $text
 * @property string $text2
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Blackday whereBlackday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blackday whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blackday whereDatumBis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blackday whereDatumVon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blackday whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blackday whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blackday whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blackday whereText2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blackday whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blackday whereUpdatedAt($value)
 */
class Blackday extends Model
{
    use SoftDeletes;

    protected $table = 'blackday';
    protected $dates = ['deleted_at'];
}
