<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\SeitenError
 *
 * @property int $id
 * @property int $errorcode
 * @property string $errorheader
 * @property string $errortitel
 * @property string $errortext
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenError whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenError whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenError whereErrorcode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenError whereErrorheader($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenError whereErrortext($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenError whereErrortitel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenError whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenError whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SeitenError newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SeitenError newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenError onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SeitenError query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenError withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenError withoutTrashed()
 */
class SeitenError extends Model
{
    use SoftDeletes;

    protected $table = 'cms_seiten_error';
    protected $dates = ['deleted_at'];
}
