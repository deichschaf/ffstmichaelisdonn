<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\MitgliedCardUrlChecker
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardUrlChecker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardUrlChecker newQuery()
 * @method static Builder|MitgliedCardUrlChecker onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedCardUrlChecker query()
 * @method static Builder|MitgliedCardUrlChecker withTrashed()
 * @method static Builder|MitgliedCardUrlChecker withoutTrashed()
 * @mixin Eloquent
 */
class MitgliedCardUrlChecker extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'mitgliedcard_url_check';
}
