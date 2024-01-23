<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\MusikzugMitglied
 *
 * @method static \Illuminate\Database\Eloquent\Builder|MusikzugMitglied newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MusikzugMitglied newQuery()
 * @method static \Illuminate\Database\Query\Builder|MusikzugMitglied onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MusikzugMitglied query()
 * @method static \Illuminate\Database\Query\Builder|MusikzugMitglied withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MusikzugMitglied withoutTrashed()
 * @mixin \Eloquent
 */
class MusikzugMitglied extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_mitglieder_musikzug';
}
