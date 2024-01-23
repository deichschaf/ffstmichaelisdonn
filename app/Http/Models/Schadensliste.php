<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\Schadensliste
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Schadensliste newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schadensliste newQuery()
 * @method static Builder|Schadensliste onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Schadensliste query()
 * @method static Builder|Schadensliste withTrashed()
 * @method static Builder|Schadensliste withoutTrashed()
 * @mixin Eloquent
 */
class Schadensliste extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'schadensliste';
}
