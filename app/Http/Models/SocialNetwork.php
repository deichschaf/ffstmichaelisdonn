<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\SocialNetwork
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SocialNetwork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SocialNetwork newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SocialNetwork onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SocialNetwork query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SocialNetwork withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SocialNetwork withoutTrashed()
 * @mixin \Eloquent
 */
class SocialNetwork extends Model
{
    use SoftDeletes;

    protected $table = 'social_network';
    protected $dates = ['deleted_at'];
}
