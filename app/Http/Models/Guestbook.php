<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\Guestbook
 *
 * @mixin Eloquent
 * @property integer $id
 * @property string $datum
 * @property string $name
 * @property string $ort
 * @property string $betreff
 * @property string $beitrag
 * @property string $emailadresse
 * @property string $www
 * @property string $icq
 * @property string $aim
 * @property string $ip
 * @property string $ver_oeff
 * @property string $spam
 * @property string $commentator
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|Guestbook whereId($value)
 * @method static Builder|Guestbook whereDatum($value)
 * @method static Builder|Guestbook whereName($value)
 * @method static Builder|Guestbook whereOrt($value)
 * @method static Builder|Guestbook whereBetreff($value)
 * @method static Builder|Guestbook whereBeitrag($value)
 * @method static Builder|Guestbook whereEmailadresse($value)
 * @method static Builder|Guestbook whereWww($value)
 * @method static Builder|Guestbook whereIcq($value)
 * @method static Builder|Guestbook whereAim($value)
 * @method static Builder|Guestbook whereIp($value)
 * @method static Builder|Guestbook whereVerOeff($value)
 * @method static Builder|Guestbook whereSpam($value)
 * @method static Builder|Guestbook whereCommentar($value)
 * @method static Builder|Guestbook whereCreatedAt($value)
 * @method static Builder|Guestbook whereUpdatedAt($value)
 * @property Carbon $deleted_at
 * @method static Builder|Guestbook whereDeletedAt($value)
 * @property int $gaestebuch_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Guestbook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guestbook newQuery()
 * @method static Builder|Guestbook onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Guestbook query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Guestbook whereGaestebuchId($value)
 * @method static Builder|Guestbook withTrashed()
 * @method static Builder|Guestbook withoutTrashed()
 * @property string|null $commentar
 */
class Guestbook extends Model
{
    use SoftDeletes;

    protected $table = 'cms_gaestebuch';
    protected $dates = ['deleted_at'];
}
