<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Funktionsvorraussetzung
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Funktionsvorraussetzung newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Funktionsvorraussetzung newQuery()
 * @method static \Illuminate\Database\Query\Builder|Funktionsvorraussetzung onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Funktionsvorraussetzung query()
 * @method static \Illuminate\Database\Query\Builder|Funktionsvorraussetzung withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Funktionsvorraussetzung withoutTrashed()
 * @mixin \Eloquent
 */
class Funktionsvorraussetzung extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_funktionen_grundvorraussetzung';
}
