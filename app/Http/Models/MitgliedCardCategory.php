<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\MitgliedCardCategory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardCategory newQuery()
 * @method static \Illuminate\Database\Query\Builder|MitgliedCardCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardCategory query()
 * @method static \Illuminate\Database\Query\Builder|MitgliedCardCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MitgliedCardCategory withoutTrashed()
 * @mixin \Eloquent
 */
class MitgliedCardCategory extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'mitgliedcard_kategorie';
}
