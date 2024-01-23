<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\CronJob
 *
 * @mixin Eloquent
 * @property integer $id
 * @property string $name
 * @property string $wehrfuehrer
 * @property string $adresse
 * @property string $plz
 * @property string $ort
 * @property string $www
 * @property string $active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|FeuerwehrenAmt whereId($value)
 * @method static Builder|FeuerwehrenAmt whereName($value)
 * @method static Builder|FeuerwehrenAmt whereWehrfuehrer($value)
 * @method static Builder|FeuerwehrenAmt whereAdresse($value)
 * @method static Builder|FeuerwehrenAmt wherePlz($value)
 * @method static Builder|FeuerwehrenAmt whereOrt($value)
 * @method static Builder|FeuerwehrenAmt whereWww($value)
 * @method static Builder|FeuerwehrenAmt whereActive($value)
 * @method static Builder|FeuerwehrenAmt whereCreatedAt($value)
 * @method static Builder|FeuerwehrenAmt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrenAmt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrenAmt newQuery()
 * @method static Builder|FeuerwehrenAmt onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrenAmt query()
 * @method static Builder|FeuerwehrenAmt withTrashed()
 * @method static Builder|FeuerwehrenAmt withoutTrashed()
 */
class FeuerwehrenAmt extends Model
{
    use SoftDeletes;

    protected $table = 'cms_feuerwehren_amt';
    protected $dates = ['deleted_at'];
}
