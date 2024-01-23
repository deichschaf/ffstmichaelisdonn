<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\MitgliedCardAdressCountry
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardAdressCountry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardAdressCountry newQuery()
 * @method static Builder|MitgliedCardAdressCountry onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardAdressCountry query()
 * @method static Builder|MitgliedCardAdressCountry withTrashed()
 * @method static Builder|MitgliedCardAdressCountry withoutTrashed()
 * @mixin Eloquent
 */
class MitgliedCardAdressCountry extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'mitgliedcard_adressen_kreis';
}
