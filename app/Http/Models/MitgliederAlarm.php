<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\MitgliederAlarm
 *
 * @property int $id
 * @property int $cms_mitglieder_id
 * @property string $boss_925
 * @property string $handy
 * @property string $vollalarm
 * @property string $loeschhilfe
 * @property string $fuehrung
 * @property string $sirene
 * @property string $melder_pw
 * @property string $is_delete
 * @property string $datum
 * @property string $tel_a
 * @property string $tel_b
 * @property string $tel_c
 * @property string $tel_d
 * @property string $pressewart
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm newQuery()
 * @method static \Illuminate\Database\Query\Builder|MitgliederAlarm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm query()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereBoss925($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereCmsMitgliederId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereDatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereFuehrung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereHandy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereIsDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereLoeschhilfe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereMelderPw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm wherePressewart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereSirene($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereTelA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereTelB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereTelC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereTelD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederAlarm whereVollalarm($value)
 * @method static \Illuminate\Database\Query\Builder|MitgliederAlarm withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MitgliederAlarm withoutTrashed()
 * @mixin \Eloquent
 */
class MitgliederAlarm extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_mitglieder_alarmierung';
}
