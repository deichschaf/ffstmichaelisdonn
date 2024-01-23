<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\CriticalSender
 *
 * @property int $id
 * @property string $senderid
 * @property string $sendername
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSender newQuery()
 * @method static \Illuminate\Database\Query\Builder|CriticalSender onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSender query()
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSender whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSender whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSender whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSender whereSenderid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSender whereSendername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSender whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CriticalSender withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CriticalSender withoutTrashed()
 * @mixin \Eloquent
 */
class CriticalSender extends Model
{
    use SoftDeletes;

    protected $table = 'critical_sender';
    protected $dates = ['deleted_at'];
}
