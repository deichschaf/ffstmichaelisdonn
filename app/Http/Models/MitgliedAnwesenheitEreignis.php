<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\MitgliedAnwesenheitEreignis
 *
 * @property int $id
 * @property string $date_time
 * @property string $ereignis
 * @property int $einsatz_id
 * @property int $termin_id
 * @property string $send_mail
 * @property string $anwesenheit_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis newQuery()
 * @method static Builder|MitgliedAnwesenheitEreignis onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis query()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis whereAnwesenheitToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis whereDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis whereEinsatzId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis whereEreignis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis whereSendMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis whereTerminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedAnwesenheitEreignis whereUpdatedAt($value)
 * @method static Builder|MitgliedAnwesenheitEreignis withTrashed()
 * @method static Builder|MitgliedAnwesenheitEreignis withoutTrashed()
 * @mixin Eloquent
 */
class MitgliedAnwesenheitEreignis extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_mitglieder_anwesenheit_ereignis';
}
