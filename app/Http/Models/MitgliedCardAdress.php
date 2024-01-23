<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\MitgliedCardAdress
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardAdress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardAdress newQuery()
 * @method static \Illuminate\Database\Query\Builder|MitgliedCardAdress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardAdress query()
 * @method static \Illuminate\Database\Query\Builder|MitgliedCardAdress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MitgliedCardAdress withoutTrashed()
 * @mixin \Eloquent
 */
class MitgliedCardAdress extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'mitgliedcard_adressen';
}
