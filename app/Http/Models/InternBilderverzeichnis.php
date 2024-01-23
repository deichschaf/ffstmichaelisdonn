<?php

/**
 * Created by PhpStorm.
 * User: Jörg
 * Date: 13.04.2015
 * Time: 17:13
 */

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\InternBilderverzeichnis
 *
 * @method static \Illuminate\Database\Eloquent\Builder|InternBilderverzeichnis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InternBilderverzeichnis newQuery()
 * @method static Builder|InternBilderverzeichnis onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InternBilderverzeichnis query()
 * @method static Builder|InternBilderverzeichnis withTrashed()
 * @method static Builder|InternBilderverzeichnis withoutTrashed()
 * @mixin Eloquent
 */
class InternBilderverzeichnis extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_intern_bilderverzeichnis';
}
