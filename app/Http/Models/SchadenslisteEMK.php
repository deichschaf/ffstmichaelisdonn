<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\SchadenslisteEMK
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteEMK newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteEMK newQuery()
 * @method static Builder|SchadenslisteEMK onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteEMK query()
 * @method static Builder|SchadenslisteEMK withTrashed()
 * @method static Builder|SchadenslisteEMK withoutTrashed()
 * @mixin Eloquent
 */
class SchadenslisteEMK extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'schadensliste_emk';
}
