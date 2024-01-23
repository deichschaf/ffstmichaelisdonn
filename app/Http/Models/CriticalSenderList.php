<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\CriticalSenderList
 *
 * @property int $id
 * @property string $senderid
 * @property string $sendername
 * @property boolean $isactive
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSenderList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSenderList newQuery()
 * @method static \Illuminate\Database\Query\Builder|CriticalSenderList onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSenderList query()
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSenderList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSenderList whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSenderList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSenderList whereSenderid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSenderList whereSendername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSenderList whereIsactive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CriticalSenderList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CriticalSenderList withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CriticalSenderList withoutTrashed()
 * @mixin \Eloquent
 */
class CriticalSenderList extends Model
{
    use SoftDeletes;

    protected $table = 'critical_sender_list';
    protected $dates = ['deleted_at'];
}
