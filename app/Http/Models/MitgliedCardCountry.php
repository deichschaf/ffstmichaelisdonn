<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\MitgliedCardCountry
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardCountry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardCountry newQuery()
 * @method static Builder|MitgliedCardCountry onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardCountry query()
 * @method static Builder|MitgliedCardCountry withTrashed()
 * @method static Builder|MitgliedCardCountry withoutTrashed()
 * @mixin Eloquent
 */
class MitgliedCardCountry extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'mitgliedcard_kreis';
}
