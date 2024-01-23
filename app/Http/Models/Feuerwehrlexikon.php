<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Feuerwehrlexikon
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Feuerwehrlexikon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feuerwehrlexikon newQuery()
 * @method static \Illuminate\Database\Query\Builder|Feuerwehrlexikon onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Feuerwehrlexikon query()
 * @method static \Illuminate\Database\Query\Builder|Feuerwehrlexikon withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Feuerwehrlexikon withoutTrashed()
 * @mixin \Eloquent
 */
class Feuerwehrlexikon extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'feuerwehrlexikon';
}
