<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\SeitenContentTypes
 *
 * @property int $id
 * @property string $pagecontenttype
 * @property string $content_title
 * @property string $description
 * @property string $image
 * @property int $pos
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes newQuery()
 * @method static Builder|SeitenContentTypes onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes whereContentTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes wherePagecontenttype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentTypes whereUpdatedAt($value)
 * @method static Builder|SeitenContentTypes withTrashed()
 * @method static Builder|SeitenContentTypes withoutTrashed()
 * @mixin Eloquent
 */
class SeitenContentTypes extends Model
{
    use SoftDeletes;

    protected $table = 'cms_seiten_content_types';
    protected $dates = ['deleted_at'];
}
