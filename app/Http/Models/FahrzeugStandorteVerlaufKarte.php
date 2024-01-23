<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\FahrzeugStandorteVerlaufKarte
 *
 * @property int $cms_fahrzeug_standorte_verlaufkarte_id
 * @property string $karte
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlaufKarte newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlaufKarte newQuery()
 * @method static Builder|FahrzeugStandorteVerlaufKarte onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlaufKarte query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlaufKarte whereCmsFahrzeugStandorteVerlaufkarteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlaufKarte whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlaufKarte whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlaufKarte whereKarte($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FahrzeugStandorteVerlaufKarte whereUpdatedAt($value)
 * @method static Builder|FahrzeugStandorteVerlaufKarte withTrashed()
 * @method static Builder|FahrzeugStandorteVerlaufKarte withoutTrashed()
 * @mixin Eloquent
 */
class FahrzeugStandorteVerlaufKarte extends Model
{
    use SoftDeletes;

    protected $table = 'cms_fahrzeug_standorte_verlaufkarten';
    protected $dates = ['deleted_at'];
}
