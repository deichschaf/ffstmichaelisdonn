<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Flyer
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Flyer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Flyer newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Flyer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Flyer query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Flyer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Flyer withoutTrashed()
 * @mixin \Eloquent
 */
class Flyer extends Model
{
    use SoftDeletes;

    protected $table = 'cms_flyer';
    protected $dates = ['deleted_at'];
}
