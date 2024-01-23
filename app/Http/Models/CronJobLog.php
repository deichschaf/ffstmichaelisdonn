<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\CronJobLog
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\CronJobLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\CronJobLog newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\CronJobLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\CronJobLog query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\CronJobLog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\CronJobLog withoutTrashed()
 * @mixin \Eloquent
 */
class CronJobLog extends Model
{
    use SoftDeletes;

    protected $table = 'cms_cronjob_log';
    protected $dates = ['deleted_at'];
}
