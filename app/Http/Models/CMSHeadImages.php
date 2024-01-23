<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\CMSHeadImages
 *
 * @property int $id
 * @property string|null $image_title
 * @property string|null $image_text
 * @property string $image
 * @property string $position
 * @property string $default_image
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages newQuery()
 * @method static Builder|CMSHeadImages onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages query()
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages whereDefaultImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages whereImageText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages whereImageTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CMSHeadImages whereUpdatedAt($value)
 * @method static Builder|CMSHeadImages withTrashed()
 * @method static Builder|CMSHeadImages withoutTrashed()
 * @mixin Eloquent
 */
class CMSHeadImages extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_headimages';
}
