<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\FahrzeugAusstattung
 *
 * @property int $fahrzeug_ausstattung_id
 * @property int $fahrzeug_id
 * @property string $fahrzeug_ausstattung
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static Builder|FahrzeugAusstattung newModelQuery()
 * @method static Builder|FahrzeugAusstattung newQuery()
 * @method static \Illuminate\Database\Query\Builder|FahrzeugAusstattung onlyTrashed()
 * @method static Builder|FahrzeugAusstattung query()
 * @method static bool|null restore()
 * @method static Builder|FahrzeugAusstattung whereCreatedAt($value)
 * @method static Builder|FahrzeugAusstattung whereDeletedAt($value)
 * @method static Builder|FahrzeugAusstattung whereFahrzeugAusstattung($value)
 * @method static Builder|FahrzeugAusstattung whereFahrzeugAusstattungId($value)
 * @method static Builder|FahrzeugAusstattung whereFahrzeugId($value)
 * @method static Builder|FahrzeugAusstattung whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|FahrzeugAusstattung withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FahrzeugAusstattung withoutTrashed()
 * @mixin Eloquent
 * @property int $id
 * @method static Builder|FahrzeugAusstattung whereId($value)
 */
class FahrzeugAusstattung extends Model
{
    use SoftDeletes;

    protected $table = 'cms_fahrzeug_ausstattung';
    protected $dates = ['deleted_at'];
}
