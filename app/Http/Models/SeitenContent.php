<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\SeitenContent
 *
 * @property int $id
 * @property int $page_id
 * @property int $pos
 * @property string|null $content_titel
 * @property string|null $content_text
 * @property string|null $content_url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent newQuery()
 * @method static Builder|SeitenContent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent whereContentText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent whereContentTitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent whereContentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContent whereUpdatedAt($value)
 * @method static Builder|SeitenContent withTrashed()
 * @method static Builder|SeitenContent withoutTrashed()
 * @mixin Eloquent
 */
class SeitenContent extends Model
{
    use SoftDeletes;

    protected $table = 'cms_seiten_content';
    protected $dates = ['deleted_at'];
}
