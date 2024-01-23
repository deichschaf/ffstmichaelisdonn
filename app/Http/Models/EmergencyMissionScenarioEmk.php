<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyMissionScenarioEmk extends Model
{
    use SoftDeletes;

    protected $table = 'cms_emergency_mission_scenario_emk';
    protected $dates = ['deleted_at'];
}
