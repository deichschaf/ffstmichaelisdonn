<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Download
 *
 * @property int $download_id
 * @property string $download_erstellt_am
 * @property string $download_titel
 * @property string|null $download_beschreibung
 * @property string|null $download_file
 * @property string $download_datum_zeit
 * @property int $download_count
 * @property string $download_key
 * @property string $download_admin
 * @property int $download_kategorie_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Download onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereDownloadAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereDownloadBeschreibung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereDownloadDatumZeit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereDownloadErstelltAm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereDownloadFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereDownloadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereDownloadKategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereDownloadKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereDownloadTitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Download whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Download withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Download withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @method static \Illuminate\Database\Eloquent\Builder|Download whereId($value)
 */
class Download extends Model
{
    use SoftDeletes;

    protected $table = 'cms_download';
    protected $dates = ['deleted_at'];
}
