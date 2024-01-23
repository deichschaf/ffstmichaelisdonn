<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\Schiffstraffic
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Schiffstraffic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schiffstraffic newQuery()
 * @method static Builder|Schiffstraffic onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Schiffstraffic query()
 * @method static Builder|Schiffstraffic withTrashed()
 * @method static Builder|Schiffstraffic withoutTrashed()
 * @mixin Eloquent
 */
class Schiffstraffic extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_schiffstraffic';
}
