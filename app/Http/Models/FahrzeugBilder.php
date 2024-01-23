<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\FahrzeugBilder
 *
 * @property int $id
 * @property int $fahrzeug_id
 * @property string|null $fahrzeug_token
 * @property string|null $fahrzeug_bild
 * @property string|null $fahrzeug_bild_titel
 * @property string|null $fahrzeug_bild_beschreibung
 * @property int $pos
 * @property string|null $fahrzeug_bild_fotograf
 * @property int $cms_fahrzeug_fotograf_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder newQuery()
 * @method static Builder|FahrzeugBilder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereCmsFahrzeugFotografId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereFahrzeugBild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereFahrzeugBildBeschreibung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereFahrzeugBildFotograf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereFahrzeugBildTitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereFahrzeugId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereFahrzeugToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereIsDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugBilder whereUpdatedAt($value)
 * @method static Builder|FahrzeugBilder withTrashed()
 * @method static Builder|FahrzeugBilder withoutTrashed()
 * @mixin Eloquent
 */
class FahrzeugBilder extends Model
{
    use SoftDeletes;

    protected $table = 'cms_fahrzeug_bilder';
    protected $dates = ['deleted_at'];
}
