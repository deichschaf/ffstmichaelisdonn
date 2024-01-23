<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\MitgliedCardAdressCategory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardAdressCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardAdressCategory newQuery()
 * @method static \Illuminate\Database\Query\Builder|MitgliedCardAdressCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardAdressCategory query()
 * @method static \Illuminate\Database\Query\Builder|MitgliedCardAdressCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MitgliedCardAdressCategory withoutTrashed()
 * @mixin \Eloquent
 */
class MitgliedCardAdressCategory extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'mitgliedcard_adresse_kategorie';
}
