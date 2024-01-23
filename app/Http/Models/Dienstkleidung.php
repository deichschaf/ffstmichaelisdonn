<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Dienstkleidung
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Dienstkleidung newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dienstkleidung newQuery()
 * @method static \Illuminate\Database\Query\Builder|Dienstkleidung onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Dienstkleidung query()
 * @method static \Illuminate\Database\Query\Builder|Dienstkleidung withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Dienstkleidung withoutTrashed()
 * @mixin \Eloquent
 */
class Dienstkleidung extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_dienstkleidung';
}
