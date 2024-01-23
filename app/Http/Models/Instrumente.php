<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Instrumente
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Instrumente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Instrumente newQuery()
 * @method static \Illuminate\Database\Query\Builder|Instrumente onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Instrumente query()
 * @method static \Illuminate\Database\Query\Builder|Instrumente withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Instrumente withoutTrashed()
 * @mixin \Eloquent
 */
class Instrumente extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_instrumente';
}
