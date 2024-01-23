<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\Vorstand
 *
 * @property int $id
 * @property int $cms_mitglieder_id
 * @property int $cms_vorstand_position_id
 * @property string $pos
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Vorstand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vorstand newQuery()
 * @method static Builder|Vorstand onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Vorstand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vorstand whereCmsMitgliederId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vorstand whereCmsVorstandPositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vorstand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vorstand whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vorstand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vorstand wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vorstand whereUpdatedAt($value)
 * @method static Builder|Vorstand withTrashed()
 * @method static Builder|Vorstand withoutTrashed()
 * @mixin Eloquent
 */
class Vorstand extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_vorstand';
}
