<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Changelog
 *
 * @property int $id
 * @property string|null $release
 * @property string|null $datum
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Changelog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Changelog newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Changelog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Changelog query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Changelog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Changelog whereDatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Changelog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Changelog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Changelog whereRelease($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Changelog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Changelog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Changelog withoutTrashed()
 * @mixin \Eloquent
 */
class Changelog extends Model
{
    use SoftDeletes;

    protected $table = 'cms_changelog';
    protected $dates = ['deleted_at'];
}
