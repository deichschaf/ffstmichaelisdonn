<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\Widget
 *
 * @mixin Eloquent
 * @property integer $id
 * @property string $WidgetName
 * @property string $param
 * @property string $position
 * @property integer $pos
 * @property string $active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|Widget whereId($value)
 * @method static Builder|Widget whereWidgetName($value)
 * @method static Builder|Widget whereParam($value)
 * @method static Builder|Widget wherePosition($value)
 * @method static Builder|Widget wherePos($value)
 * @method static Builder|Widget whereActive($value)
 * @method static Builder|Widget whereCreatedAt($value)
 * @method static Builder|Widget whereUpdatedAt($value)
 * @property Carbon $deleted_at
 * @method static Builder|Widget whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget newQuery()
 * @method static Builder|Widget onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Widget query()
 * @method static bool|null restore()
 * @method static Builder|Widget withTrashed()
 * @method static Builder|Widget withoutTrashed()
 */
class Widget extends Model
{
    use SoftDeletes;

    protected $table = 'cms_widget';
    protected $dates = ['deleted_at'];
}
