<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Headimages
 *
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Headimages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Headimages newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Headimages onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Headimages query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Headimages withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Headimages withoutTrashed()
 * @property int $id
 * @property string|null $image_title
 * @property string|null $image_text
 * @property string $image
 * @property string $position
 * @property string $default_image
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Headimages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Headimages whereDefaultImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Headimages whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Headimages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Headimages whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Headimages whereImageText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Headimages whereImageTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Headimages wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Headimages whereUpdatedAt($value)
 */
class Headimages extends Model
{
    use SoftDeletes;

    protected $table = 'cms_headimages';
    protected $dates = ['deleted_at'];
}
