<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Wartung
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $titel
 * @property string $beschreibung
 * @property string $beginn
 * @property string $ende
 * @property string $aktiv
 * @property string $erstellt_am
 * @property string $erstellt_von
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung whereTitel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung whereBeschreibung($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung whereBeginn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung whereEnde($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung whereAktiv($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung whereErstelltAm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung whereErstelltVon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung whereUpdatedAt($value)
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung whereDeletedAt($value)
 * @property int $cms_wartung_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wartung newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wartung newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wartung query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Wartung whereCmsWartungId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Wartung withoutTrashed()
 */
class Wartung extends Model
{
    use SoftDeletes;

    protected $table = 'cms_wartung';
    protected $dates = ['deleted_at'];
}
