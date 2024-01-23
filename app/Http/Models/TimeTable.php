<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\TimeTable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TimeTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeTable newQuery()
 * @method static Builder|TimeTable onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeTable query()
 * @method static Builder|TimeTable withTrashed()
 * @method static Builder|TimeTable withoutTrashed()
 * @mixin Eloquent
 */
class TimeTable extends Model
{
    use SoftDeletes;

    protected $table = 'cms_timetable';
    protected $dates = ['deleted_at'];
}
