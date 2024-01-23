<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\UserLogin
 *
 * @mixin Eloquent
 * @property integer $id
 * @property integer $timestamp
 * @property string $date_time
 * @property string $login_status
 * @property string $browser
 * @property string $ip
 * @property string $proxy
 * @property string $hosts
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|UserLogin whereId($value)
 * @method static Builder|UserLogin whereTimestamp($value)
 * @method static Builder|UserLogin whereDateTime($value)
 * @method static Builder|UserLogin whereLoginStatus($value)
 * @method static Builder|UserLogin whereBrowser($value)
 * @method static Builder|UserLogin whereIp($value)
 * @method static Builder|UserLogin whereProxy($value)
 * @method static Builder|UserLogin whereHosts($value)
 * @method static Builder|UserLogin whereCreatedAt($value)
 * @method static Builder|UserLogin whereUpdatedAt($value)
 * @property Carbon $deleted_at
 * @method static Builder|UserLogin whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin newQuery()
 * @method static Builder|UserLogin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLogin query()
 * @method static bool|null restore()
 * @method static Builder|UserLogin withTrashed()
 * @method static Builder|UserLogin withoutTrashed()
 */
class UserLogin extends Model
{
    use SoftDeletes;

    protected $table = 'user_login';
    protected $dates = ['deleted_at'];
}
