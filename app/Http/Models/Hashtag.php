<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Hashtag
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Hashtag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hashtag newQuery()
 * @method static \Illuminate\Database\Query\Builder|Hashtag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Hashtag query()
 * @method static \Illuminate\Database\Query\Builder|Hashtag withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Hashtag withoutTrashed()
 * @mixin \Eloquent
 */
class Hashtag extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'hashtag';
}
