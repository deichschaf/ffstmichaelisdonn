<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\SchadenslisteEW
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteEW newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteEW newQuery()
 * @method static Builder|SchadenslisteEW onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteEW query()
 * @method static Builder|SchadenslisteEW withTrashed()
 * @method static Builder|SchadenslisteEW withoutTrashed()
 * @mixin Eloquent
 */
class SchadenslisteEW extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'schadensliste_ew';
}
