<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\MitgliederTELFunktionen
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederTELFunktionen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederTELFunktionen newQuery()
 * @method static \Illuminate\Database\Query\Builder|MitgliederTELFunktionen onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliederTELFunktionen query()
 * @method static \Illuminate\Database\Query\Builder|MitgliederTELFunktionen withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MitgliederTELFunktionen withoutTrashed()
 * @mixin \Eloquent
 */
class MitgliederTELFunktionen extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_mitglied_tel_funktion';
}
