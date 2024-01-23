<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\MitgliedDienstkleidung
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedDienstkleidung newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedDienstkleidung newQuery()
 * @method static \Illuminate\Database\Query\Builder|MitgliedDienstkleidung onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MitgliedDienstkleidung query()
 * @method static \Illuminate\Database\Query\Builder|MitgliedDienstkleidung withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MitgliedDienstkleidung withoutTrashed()
 * @mixin \Eloquent
 */
class MitgliedDienstkleidung extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_mitglieder_dienstkleidung';
}
