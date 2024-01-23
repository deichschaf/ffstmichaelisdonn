<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\FacebookImageGenerator
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FacebookImageGenerator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacebookImageGenerator newQuery()
 * @method static Builder|FacebookImageGenerator onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FacebookImageGenerator query()
 * @method static Builder|FacebookImageGenerator withTrashed()
 * @method static Builder|FacebookImageGenerator withoutTrashed()
 * @mixin Eloquent
 */
class FacebookImageGenerator extends Model
{
    use SoftDeletes;

    protected $table = 'facebook_image_generator';
    protected $dates = ['deleted_at'];
}
