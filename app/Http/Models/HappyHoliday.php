<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\HappyHoliday
 *
 * @mixin Eloquent
 * @property integer $id
 * @property string $beginn
 * @property string $end
 * @property string $template
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|HappyHoliday whereId($value)
 * @method static Builder|HappyHoliday whereBeginn($value)
 * @method static Builder|HappyHoliday whereEnd($value)
 * @method static Builder|HappyHoliday whereTemplate($value)
 * @method static Builder|HappyHoliday whereCreatedAt($value)
 * @method static Builder|HappyHoliday whereUpdatedAt($value)
 * @property Carbon $deleted_at
 * @method static Builder|HappyHoliday whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|HappyHoliday newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HappyHoliday newQuery()
 * @method static Builder|HappyHoliday onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|HappyHoliday query()
 * @method static bool|null restore()
 * @method static Builder|HappyHoliday withTrashed()
 * @method static Builder|HappyHoliday withoutTrashed()
 */
class HappyHoliday extends Model
{
    use SoftDeletes;

    protected $table = 'happy_holiday';
    protected $dates = ['deleted_at'];
}
