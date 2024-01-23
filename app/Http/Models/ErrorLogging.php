<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\ErrorLogging
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ErrorLogging newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrorLogging newQuery()
 * @method static \Illuminate\Database\Query\Builder|ErrorLogging onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrorLogging query()
 * @method static \Illuminate\Database\Query\Builder|ErrorLogging withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ErrorLogging withoutTrashed()
 * @mixin \Eloquent
 */
class ErrorLogging extends Model
{
    use SoftDeletes;

    protected $table = 'cms_errorlogging';
    protected $dates = ['deleted_at'];
}
