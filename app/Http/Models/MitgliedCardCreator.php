<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\MitgliedCardCreator
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardCreator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardCreator newQuery()
 * @method static Builder|MitgliedCardCreator onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardCreator query()
 * @method static Builder|MitgliedCardCreator withTrashed()
 * @method static Builder|MitgliedCardCreator withoutTrashed()
 * @mixin Eloquent
 */
class MitgliedCardCreator extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'mitgliedcard_creator';
}
