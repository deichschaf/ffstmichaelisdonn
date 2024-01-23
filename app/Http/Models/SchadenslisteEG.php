<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\SchadenslisteEG
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteEG newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteEG newQuery()
 * @method static \Illuminate\Database\Query\Builder|SchadenslisteEG onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteEG query()
 * @method static \Illuminate\Database\Query\Builder|SchadenslisteEG withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SchadenslisteEG withoutTrashed()
 * @mixin \Eloquent
 */
class SchadenslisteEG extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'schadensliste_eg';
}
