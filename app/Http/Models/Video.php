<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Video
 *
 * @property int $cms_video_id
 * @property string $video_titel
 * @property string $video_link
 * @property string $video_beschreibung
 * @property int $counter
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Video newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Video onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Video query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Video whereCmsVideoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Video whereCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Video whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Video whereVideoBeschreibung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Video whereVideoLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Video whereVideoTitel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Video withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Video withoutTrashed()
 * @mixin \Eloquent
 */
class Video extends Model
{
    use SoftDeletes;

    protected $table = 'cms_videos';
    protected $dates = ['deleted_at'];
}
