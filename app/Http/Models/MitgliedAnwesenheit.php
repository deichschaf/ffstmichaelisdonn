<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\MitgliedAnwesenheit
 *
 * @property int $id
 * @property int $cms_mitglieder_anwesenheit_ereignis_id
 * @property int $mitglied_id
 * @property string $status
 * @property string $bemerkung
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheit newQuery()
 * @method static Builder|MitgliedAnwesenheit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheit query()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheit whereBemerkung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheit whereCmsMitgliederAnwesenheitEreignisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheit whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheit whereMitgliedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheit whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheit whereUpdatedAt($value)
 * @method static Builder|MitgliedAnwesenheit withTrashed()
 * @method static Builder|MitgliedAnwesenheit withoutTrashed()
 * @mixin Eloquent
 */
class MitgliedAnwesenheit extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_mitglieder_anwesenheit';
}
