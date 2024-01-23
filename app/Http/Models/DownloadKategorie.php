<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\DownloadKategorie
 *
 * @property int $download_kategorie_id
 * @property string $download_kategorie
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static Builder|DownloadKategorie newModelQuery()
 * @method static Builder|DownloadKategorie newQuery()
 * @method static \Illuminate\Database\Query\Builder|DownloadKategorie onlyTrashed()
 * @method static Builder|DownloadKategorie query()
 * @method static bool|null restore()
 * @method static Builder|DownloadKategorie whereCreatedAt($value)
 * @method static Builder|DownloadKategorie whereDeletedAt($value)
 * @method static Builder|DownloadKategorie whereDownloadKategorie($value)
 * @method static Builder|DownloadKategorie whereDownloadKategorieId($value)
 * @method static Builder|DownloadKategorie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|DownloadKategorie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DownloadKategorie withoutTrashed()
 * @mixin Eloquent
 * @property int $id
 * @method static Builder|DownloadKategorie whereId($value)
 */
class DownloadKategorie extends Model
{
    use SoftDeletes;

    protected $table = 'cms_download_kategorie';
    protected $dates = ['deleted_at'];
}
