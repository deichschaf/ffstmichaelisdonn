<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\AdminLoginLog
 *
 * @mixin Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLoginLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLoginLog newQuery()
 * @method static Builder|AdminLoginLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLoginLog query()
 * @method static bool|null restore()
 * @method static Builder|AdminLoginLog withTrashed()
 * @method static Builder|AdminLoginLog withoutTrashed()
 */
class AdminLoginLog extends Model
{
    use SoftDeletes;

    protected $table = 'cms_adminloginlog';
    protected $dates = ['deleted_at'];
}
