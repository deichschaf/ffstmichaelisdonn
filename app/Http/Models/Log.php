<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Log
 *
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Log newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Log onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Log query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Log withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Log withoutTrashed()
 */
class Log extends Model
{
    use SoftDeletes;

    protected $table = 'weblog';
    protected $dates = ['deleted_at'];
}
