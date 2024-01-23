<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Metatags
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $metatag
 * @property string $metatag_text
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Metatags whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Metatags whereMetatag($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Metatags whereMetatagText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Metatags whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Metatags whereUpdatedAt($value)
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Metatags whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Metatags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Metatags newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Metatags onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Metatags query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Metatags whereMetatagId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Metatags withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Metatags withoutTrashed()
 */
class Metatags extends Model
{
    use SoftDeletes;

    protected $table = 'cms_metatags';
    protected $dates = ['deleted_at'];
}
