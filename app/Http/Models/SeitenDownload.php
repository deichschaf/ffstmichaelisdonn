<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\SeitenDownload
 *
 * @property int $id
 * @property int $cms_seiten_id
 * @property int $cms_download_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenDownload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenDownload newQuery()
 * @method static Builder|SeitenDownload onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenDownload query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenDownload whereCmsDownloadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenDownload whereCmsSeitenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenDownload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenDownload whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenDownload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenDownload whereUpdatedAt($value)
 * @method static Builder|SeitenDownload withTrashed()
 * @method static Builder|SeitenDownload withoutTrashed()
 * @mixin Eloquent
 */
class SeitenDownload extends Model
{
    use SoftDeletes;

    protected $table = 'cms_seiten_download';
    protected $dates = ['deleted_at'];
}
