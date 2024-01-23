<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\SeitenTexte
 *
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SeitenHeadImages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SeitenHeadImages newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenHeadImages onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SeitenHeadImages query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenHeadImages withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenHeadImages withoutTrashed()
 * @property int $id
 * @property int $page_id
 * @property int $headerimage_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenHeadImages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenHeadImages whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenHeadImages whereHeaderimageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenHeadImages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenHeadImages wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenHeadImages whereUpdatedAt($value)
 */
class SeitenHeadImages extends Model
{
    use SoftDeletes;

    protected $table = 'cms_seiten_headimages';
    protected $dates = ['deleted_at'];
}
