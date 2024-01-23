<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\FeuerwehrDienstgradeKombi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrDienstgradeKombi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrDienstgradeKombi newQuery()
 * @method static \Illuminate\Database\Query\Builder|FeuerwehrDienstgradeKombi onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FeuerwehrDienstgradeKombi query()
 * @method static \Illuminate\Database\Query\Builder|FeuerwehrDienstgradeKombi withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FeuerwehrDienstgradeKombi withoutTrashed()
 * @mixin \Eloquent
 */
class FeuerwehrDienstgradeKombi extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'feuerwehr_dienstgrade_kombi';
}
