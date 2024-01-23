<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\WachenBild
 *
 * @property int $cms_fahrzeug_ort_bilder_id
 * @property int $cms_fahrzeug_ort_id
 * @property string $bild
 * @property int $standard
 * @property string $wachen_bild_titel
 * @property string $wachen_bild_beschreibung
 * @property string $copyright
 * @property int $pos
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild newQuery()
 * @method static Builder|WachenBild onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild whereBild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild whereCmsFahrzeugOrtBilderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild whereCmsFahrzeugOrtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild whereCopyright($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild whereIsDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild whereStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild whereWachenBildBeschreibung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WachenBild whereWachenBildTitel($value)
 * @method static Builder|WachenBild withTrashed()
 * @method static Builder|WachenBild withoutTrashed()
 * @mixin Eloquent
 */
class WachenBild extends Model
{
    use SoftDeletes;

    protected $table = 'cms_fahrzeug_ort_bilder';
    protected $dates = ['deleted_at'];
}
