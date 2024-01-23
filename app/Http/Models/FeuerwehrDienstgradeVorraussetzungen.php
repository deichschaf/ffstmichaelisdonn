<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\FeuerwehrDienstgradeVorraussetzungen
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrDienstgradeVorraussetzungen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrDienstgradeVorraussetzungen newQuery()
 * @method static \Illuminate\Database\Query\Builder|FeuerwehrDienstgradeVorraussetzungen onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrDienstgradeVorraussetzungen query()
 * @method static \Illuminate\Database\Query\Builder|FeuerwehrDienstgradeVorraussetzungen withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FeuerwehrDienstgradeVorraussetzungen withoutTrashed()
 * @mixin \Eloquent
 */
class FeuerwehrDienstgradeVorraussetzungen extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'feuerwehr_dienstgrade_vorraussetzungen';
}
