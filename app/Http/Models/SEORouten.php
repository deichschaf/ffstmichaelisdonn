<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\SEORouten
 *
 * @mixin Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|SEORouten newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SEORouten newQuery()
 * @method static Builder|SEORouten onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SEORouten query()
 * @method static bool|null restore()
 * @method static Builder|SEORouten withTrashed()
 * @method static Builder|SEORouten withoutTrashed()
 */
class SEORouten extends Model
{
    use SoftDeletes;

    protected $table = 'cms_seorouten';
    protected $dates = ['deleted_at'];
}
