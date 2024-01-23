<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyTypeCategory extends Model
{
    use SoftDeletes;

    protected $table = 'cms_emergency_type_category';
    protected $dates = ['deleted_at'];
}
