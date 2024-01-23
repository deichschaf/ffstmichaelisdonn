<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\LexikonKeywords
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\LexikonKeywords newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\LexikonKeywords newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LexikonKeywords onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\LexikonKeywords query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LexikonKeywords withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LexikonKeywords withoutTrashed()
 * @mixin \Eloquent
 */
class LexikonKeywords extends Model
{
    use SoftDeletes;

    protected $table = 'cms_lexikon_keywords';
    protected $dates = ['deleted_at'];
}
