<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\MitgliedCardEhrenamtskarte
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardEhrenamtskarte newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardEhrenamtskarte newQuery()
 * @method static Builder|MitgliedCardEhrenamtskarte onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardEhrenamtskarte query()
 * @method static Builder|MitgliedCardEhrenamtskarte withTrashed()
 * @method static Builder|MitgliedCardEhrenamtskarte withoutTrashed()
 * @mixin Eloquent
 */
class MitgliedCardEhrenamtskarte extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'mitgliedcard_ehrenamtskarte';
}
