<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\Funkrufnamen
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Funkrufnamen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Funkrufnamen newQuery()
 * @method static Builder|Funkrufnamen onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Funkrufnamen query()
 * @method static bool|null restore()
 * @method static Builder|Funkrufnamen withTrashed()
 * @method static Builder|Funkrufnamen withoutTrashed()
 * @mixin Eloquent
 */
class Funkrufnamen extends Model
{
    use SoftDeletes;

    protected $table = 'cms_funkrufnamen';
    protected $dates = ['deleted_at'];
}
