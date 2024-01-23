<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\SchadenslisteRettung
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteRettung newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteRettung newQuery()
 * @method static Builder|SchadenslisteRettung onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteRettung query()
 * @method static Builder|SchadenslisteRettung withTrashed()
 * @method static Builder|SchadenslisteRettung withoutTrashed()
 * @mixin Eloquent
 */
class SchadenslisteRettung extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'schadensliste_rettungsdienst';
}
