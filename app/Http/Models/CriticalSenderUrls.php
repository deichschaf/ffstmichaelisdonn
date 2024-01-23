<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CriticalSenderUrls extends Model
{
    use SoftDeletes;

    protected $table = 'critical_sender_urls';
    protected $dates = ['deleted_at'];
}
