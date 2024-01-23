<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\CronJob
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\CronJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\CronJob newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\CronJob onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\CronJob query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\CronJob withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\CronJob withoutTrashed()
 * @mixin \Eloquent
 */
class CronJob extends Model
{
    use SoftDeletes;

    protected $table = 'cms_cronjob';
    protected $dates = ['deleted_at'];
}
