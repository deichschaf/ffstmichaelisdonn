<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\InternDownloadZuordnung
 *
 * @property int $id
 * @property int $cms_intern_download_id
 * @property int $cms_intern_download_kategorie_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadZuordnung newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadZuordnung newQuery()
 * @method static Builder|InternDownloadZuordnung onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadZuordnung query()
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadZuordnung whereCmsInternDownloadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadZuordnung whereCmsInternDownloadKategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadZuordnung whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadZuordnung whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadZuordnung whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InternDownloadZuordnung whereUpdatedAt($value)
 * @method static Builder|InternDownloadZuordnung withTrashed()
 * @method static Builder|InternDownloadZuordnung withoutTrashed()
 * @mixin Eloquent
 */
class InternDownloadZuordnung extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_intern_download_zuordnung';
}
