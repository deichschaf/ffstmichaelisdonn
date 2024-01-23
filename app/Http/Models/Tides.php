<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\Tides
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Tides newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tides newQuery()
 * @method static Builder|Tides onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tides query()
 * @method static Builder|Tides withTrashed()
 * @method static Builder|Tides withoutTrashed()
 * @mixin Eloquent
 */
class Tides extends Model
{
    use SoftDeletes;

    protected $table = 'tides';
    protected $dates = ['deleted_at'];
}
