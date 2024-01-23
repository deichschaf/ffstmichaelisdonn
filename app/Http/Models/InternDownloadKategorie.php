<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\InternDownloadKategorie
 *
 * @property int $id
 * @property string $kategorie
 * @property int $parent_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadKategorie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadKategorie newQuery()
 * @method static \Illuminate\Database\Query\Builder|InternDownloadKategorie onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadKategorie query()
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadKategorie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadKategorie whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadKategorie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadKategorie whereKategorie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadKategorie whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadKategorie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|InternDownloadKategorie withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InternDownloadKategorie withoutTrashed()
 * @mixin \Eloquent
 */
class InternDownloadKategorie extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_intern_download_kategorie';
}
