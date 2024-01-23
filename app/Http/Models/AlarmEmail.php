<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\AlarmEmail
 *
 * @property int $id
 * @property int|null $cms_einsaetze_id
 * @property string|null $from_address
 * @property string|null $to_address
 * @property string|null $message_id
 * @property string|null $mail_date
 * @property string|null $mail_subject
 * @property string|null $emergency_date_time
 * @property string|null $emergency_priority
 * @property string|null $emergency_number
 * @property string|null $emergency_workstation
 * @property string|null $emergency_scenario
 * @property string|null $emergency_info
 * @property string|null $emergency_place
 * @property string|null $emergency_place_lat
 * @property string|null $emergency_place_lng
 * @property string|null $emergency_place_info
 * @property string|null $emergency_information
 * @property string|null $emergency_stations
 * @property string|null $charset
 * @property string|null $htmlmsg
 * @property string|null $plainmsg
 * @property string|null $attachments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail newQuery()
 * @method static \Illuminate\Database\Query\Builder|AlarmEmail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail query()
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereCharset($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereCmsEinsaetzeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyPlaceInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyPlaceLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyPlaceLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyPriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyScenario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyStations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereEmergencyWorkstation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereFromAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereHtmlmsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereMailDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereMailSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail wherePlainmsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereToAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlarmEmail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|AlarmEmail withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AlarmEmail withoutTrashed()
 * @mixin \Eloquent
 */
class AlarmEmail extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'alarm_email';
}
