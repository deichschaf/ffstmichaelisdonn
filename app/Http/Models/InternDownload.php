<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\InternDownload
 *
 * @property int $id
 * @property string $titel
 * @property string $beschreibung
 * @property string $download
 * @property string $download_key
 * @property int $download_count
 * @property string $erstellt_am
 * @property string $erstellt_von
 * @property string $geaendert_am
 * @property string $geaendert_von
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload newQuery()
 * @method static \Illuminate\Database\Query\Builder|InternDownload onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload query()
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereBeschreibung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereDownload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereDownloadCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereDownloadKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereErstelltAm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereErstelltVon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereGeaendertAm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereGeaendertVon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereTitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|InternDownload withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InternDownload withoutTrashed()
 * @mixin \Eloquent
 */
class InternDownload extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_intern_download';
}
