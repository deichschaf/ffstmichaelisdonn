<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\Presse
 *
 * @property int $id
 * @property string $datum
 * @property string $ueberschrift
 * @property string $unterzeile
 * @property string $news_text
 * @property string $news_link
 * @property string $download
 * @property string $download_key
 * @property int $download_count
 * @property string $bild
 * @property string $bildunterschrift
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Presse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Presse newQuery()
 * @method static Builder|Presse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Presse query()
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereBild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereBildunterschrift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereDatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereDownload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereDownloadKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereNewsLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereNewsText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereUeberschrift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereUnterzeile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Presse whereUpdatedAt($value)
 * @method static Builder|Presse withTrashed()
 * @method static Builder|Presse withoutTrashed()
 * @mixin Eloquent
 */
class Presse extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_presse';
}
