<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\VorstandPosition
 *
 * @property int $id
 * @property string|null $positionname
 * @property string|null $positionoldname
 * @property string|null $gender
 * @property int|null $gender_parent
 * @property int|null $pos
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition newQuery()
 * @method static Builder|VorstandPosition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition query()
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition whereGenderParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition wherePositionname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition wherePositionoldname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VorstandPosition whereUpdatedAt($value)
 * @method static Builder|VorstandPosition withTrashed()
 * @method static Builder|VorstandPosition withoutTrashed()
 * @mixin Eloquent
 */
class VorstandPosition extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_vorstand_positionen';
}
