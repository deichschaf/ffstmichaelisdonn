<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\FeuerwehrDienstgrade
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrDienstgrade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrDienstgrade newQuery()
 * @method static \Illuminate\Database\Query\Builder|FeuerwehrDienstgrade onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrDienstgrade query()
 * @method static \Illuminate\Database\Query\Builder|FeuerwehrDienstgrade withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FeuerwehrDienstgrade withoutTrashed()
 * @mixin \Eloquent
 */
class FeuerwehrDienstgrade extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'feuerwehr_dienstgrade';
}
