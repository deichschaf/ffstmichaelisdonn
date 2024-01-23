<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Lexikon
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Lexikon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Lexikon newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Lexikon onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Lexikon query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Lexikon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Lexikon withoutTrashed()
 * @mixin \Eloquent
 */
class Lexikon extends Model
{
    use SoftDeletes;

    protected $table = 'cms_lexikon';
    protected $dates = ['deleted_at'];
}
