<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\SeitenContentImage
 *
 * @property int $id
 * @property int $page_id
 * @property int $pos
 * @property string|null $content_titel
 * @property string|null $content_text
 * @property string|null $content_image
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage newQuery()
 * @method static \Illuminate\Database\Query\Builder|SeitenContentImage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage whereContentImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage whereContentText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage whereContentTitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenContentImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SeitenContentImage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SeitenContentImage withoutTrashed()
 * @mixin \Eloquent
 */
class SeitenContentImage extends Model
{
    use SoftDeletes;

    protected $table = 'cms_seiten_content_image';
    protected $dates = ['deleted_at'];
}
