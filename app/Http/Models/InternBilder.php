<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\InternBilder
 *
 * @method static \Illuminate\Database\Eloquent\Builder|InternBilder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InternBilder newQuery()
 * @method static Builder|InternBilder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InternBilder query()
 * @method static Builder|InternBilder withTrashed()
 * @method static Builder|InternBilder withoutTrashed()
 * @mixin Eloquent
 */
class InternBilder extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_intern_bilder';
}
