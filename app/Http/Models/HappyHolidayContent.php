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
 * @method static Builder|HappyHolidayContent whereId($value)
 * @method static Builder|HappyHolidayContent whereBeginn($value)
 * @method static Builder|HappyHolidayContent whereEnd($value)
 * @method static Builder|HappyHolidayContent whereTemplate($value)
 * @method static Builder|HappyHolidayContent whereCreatedAt($value)
 * @method static Builder|HappyHolidayContent whereUpdatedAt($value)
 * @property Carbon $deleted_at
 * @method static Builder|HappyHolidayContent whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|HappyHolidayContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HappyHolidayContent newQuery()
 * @method static Builder|HappyHolidayContent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|HappyHolidayContent query()
 * @method static bool|null restore()
 * @method static Builder|HappyHolidayContent withTrashed()
 * @method static Builder|HappyHolidayContent withoutTrashed()
 */
class HappyHolidayContent extends Model
{
    use SoftDeletes;

    protected $table = 'happy_holiday_content';
    protected $dates = ['deleted_at'];
}
