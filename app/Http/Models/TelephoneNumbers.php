<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TelephoneNumbers extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'cms_telephone_numbers';
}
