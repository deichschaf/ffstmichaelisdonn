<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\Texte
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Texte newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Texte newQuery()
 * @method static Builder|Texte onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Texte query()
 * @method static Builder|Texte withTrashed()
 * @method static Builder|Texte withoutTrashed()
 * @mixin Eloquent
 */
class Texte extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_texte';
}
