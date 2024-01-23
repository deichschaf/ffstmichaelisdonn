<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\Intern
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Intern newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Intern newQuery()
 * @method static Builder|Intern onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Intern query()
 * @method static Builder|Intern withTrashed()
 * @method static Builder|Intern withoutTrashed()
 * @mixin Eloquent
 */
class Intern extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'intern';
}
