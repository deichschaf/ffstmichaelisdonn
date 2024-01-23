<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\NewsPresse
 *
 * @method static \Illuminate\Database\Eloquent\Builder|NewsPresse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsPresse newQuery()
 * @method static \Illuminate\Database\Query\Builder|NewsPresse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NewsPresse query()
 * @method static \Illuminate\Database\Query\Builder|NewsPresse withTrashed()
 * @method static \Illuminate\Database\Query\Builder|NewsPresse withoutTrashed()
 * @mixin \Eloquent
 */
class NewsPresse extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_news_quelle';
}
