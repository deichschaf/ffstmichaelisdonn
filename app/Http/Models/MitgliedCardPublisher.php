<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\MitgliedCardPublisher
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardPublisher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardPublisher newQuery()
 * @method static Builder|MitgliedCardPublisher onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardPublisher query()
 * @method static Builder|MitgliedCardPublisher withTrashed()
 * @method static Builder|MitgliedCardPublisher withoutTrashed()
 * @mixin Eloquent
 */
class MitgliedCardPublisher extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'mitgliedcard_herausgeber';
}
