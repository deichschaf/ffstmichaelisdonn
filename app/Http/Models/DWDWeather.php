<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\DWDWeather
 *
 * @property int $id
 * @property string|null $area
 * @property string|null $content
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|DWDWeather newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DWDWeather newQuery()
 * @method static \Illuminate\Database\Query\Builder|DWDWeather onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DWDWeather query()
 * @method static \Illuminate\Database\Eloquent\Builder|DWDWeather whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DWDWeather whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DWDWeather whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DWDWeather whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DWDWeather whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DWDWeather whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|DWDWeather withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DWDWeather withoutTrashed()
 * @mixin \Eloquent
 */
class DWDWeather extends Model
{
    use SoftDeletes;

    protected $table = 'dwd_weather';
    //protected $dates = ['deleted_at'];
}
