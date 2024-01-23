<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\EinsatzFahrzeug
 *
 * @property int $id
 * @property int $einsatz_id
 * @property int $fahrzeug_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzFahrzeug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzFahrzeug newQuery()
 * @method static \Illuminate\Database\Query\Builder|EinsatzFahrzeug onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzFahrzeug query()
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzFahrzeug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzFahrzeug whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzFahrzeug whereEinsatzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzFahrzeug whereFahrzeugId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzFahrzeug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EinsatzFahrzeug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|EinsatzFahrzeug withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EinsatzFahrzeug withoutTrashed()
 * @mixin \Eloquent
 */
class EinsatzFahrzeug extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_einsaetze_fahrzeuge';
}
