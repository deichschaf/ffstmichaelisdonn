<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TermineWearingTypes extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_termin_wearing_types';
}
