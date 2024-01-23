<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\TimeTablePlace
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TimeTablePlace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeTablePlace newQuery()
 * @method static \Illuminate\Database\Query\Builder|TimeTablePlace onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeTablePlace query()
 * @method static \Illuminate\Database\Query\Builder|TimeTablePlace withTrashed()
 * @method static \Illuminate\Database\Query\Builder|TimeTablePlace withoutTrashed()
 * @mixin \Eloquent
 */
class TimeTablePlace extends Model
{
    use SoftDeletes;

    protected $table = 'cms_timetable_place';
    protected $dates = ['deleted_at'];
}
