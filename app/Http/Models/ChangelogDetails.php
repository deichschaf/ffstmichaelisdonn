<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\ChangelogDetails
 *
 * @property int $id
 * @property int $changelog_id
 * @property string|null $tasks
 * @property int $pos
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ChangelogDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ChangelogDetails newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\ChangelogDetails onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ChangelogDetails query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ChangelogDetails whereChangelogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ChangelogDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ChangelogDetails whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ChangelogDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ChangelogDetails wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ChangelogDetails whereTasks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ChangelogDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\ChangelogDetails withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\ChangelogDetails withoutTrashed()
 * @mixin \Eloquent
 */
class ChangelogDetails extends Model
{
    use SoftDeletes;

    protected $table = 'cms_changelog_details';
    protected $dates = ['deleted_at'];
}
