<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\LinkToFacebook
 *
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\LinkToFacebook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\LinkToFacebook newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LinkToFacebook onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\LinkToFacebook query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LinkToFacebook withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LinkToFacebook withoutTrashed()
 */
class LinkToFacebook extends Model
{
    use SoftDeletes;

    protected $table = 'linktofacebook';
    protected $dates = ['deleted_at'];
}
