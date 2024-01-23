<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\MitgliederFuehrerschein
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederFuehrerschein newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederFuehrerschein newQuery()
 * @method static Builder|MitgliederFuehrerschein onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederFuehrerschein query()
 * @method static Builder|MitgliederFuehrerschein withTrashed()
 * @method static Builder|MitgliederFuehrerschein withoutTrashed()
 * @mixin Eloquent
 */
class MitgliederFuehrerschein extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_mitglieder_fuehrerscheine';
}
