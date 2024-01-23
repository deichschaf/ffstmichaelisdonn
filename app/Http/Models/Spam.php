<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Spam
 *
 * @property int $id
 * @property string $spam
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Spam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Spam newQuery()
 * @method static \Illuminate\Database\Query\Builder|Spam onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Spam query()
 * @method static \Illuminate\Database\Eloquent\Builder|Spam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spam whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spam whereSpam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Spam withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Spam withoutTrashed()
 * @mixin \Eloquent
 */
class Spam extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_spam';
}
