<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\SchadenslisteGSA
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteGSA newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteGSA newQuery()
 * @method static Builder|SchadenslisteGSA onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SchadenslisteGSA query()
 * @method static Builder|SchadenslisteGSA withTrashed()
 * @method static Builder|SchadenslisteGSA withoutTrashed()
 * @mixin Eloquent
 */
class SchadenslisteGSA extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'schadensliste_gsa';
}
