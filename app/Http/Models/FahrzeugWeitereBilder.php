<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\FahrzeugWeitereBilder
 *
 * @property int $cms_fahrzeug_weitere_id
 * @property int $cms_fahrzeug_ort_id
 * @property string $bild
 * @property int $standard
 * @property string $weitere_bild_titel
 * @property string $weitere_bild_beschreibung
 * @property string $copyright
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder newQuery()
 * @method static Builder|FahrzeugWeitereBilder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder whereBild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder whereCmsFahrzeugOrtId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder whereCmsFahrzeugWeitereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder whereCopyright($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder whereIsDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder whereStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder whereWeitereBildBeschreibung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugWeitereBilder whereWeitereBildTitel($value)
 * @method static Builder|FahrzeugWeitereBilder withTrashed()
 * @method static Builder|FahrzeugWeitereBilder withoutTrashed()
 * @mixin Eloquent
 */
class FahrzeugWeitereBilder extends Model
{
    use SoftDeletes;

    protected $table = 'cms_fahrzeug_weitere_bilder';
    protected $dates = ['deleted_at'];
}
