<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\Kontakt
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Kontakt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kontakt newQuery()
 * @method static Builder|Kontakt onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Kontakt query()
 * @method static Builder|Kontakt withTrashed()
 * @method static Builder|Kontakt withoutTrashed()
 * @mixin Eloquent
 */
class Kontakt extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_kontakt';
}
