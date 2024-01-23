<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\LinksKategorien
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $link_kategorie
 * @property integer $pos
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LinksKategorien whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LinksKategorien whereLinkKategorie($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LinksKategorien wherePos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LinksKategorien whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LinksKategorien whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\LinksKategorien newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\LinksKategorien newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LinksKategorien onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\LinksKategorien query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\LinksKategorien whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\LinksKategorien whereLinkKategorieId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LinksKategorien withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\LinksKategorien withoutTrashed()
 */
class LinksKategorien extends Model
{
    use SoftDeletes;

    protected $table = 'cms_links_kategorien';
    protected $dates = ['deleted_at'];
}
