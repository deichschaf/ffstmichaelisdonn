<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Bilder
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $cms_bilder_id
 * @property integer $cms_bilderverzeichnis_id
 * @property string $cms_bild
 * @property string $cms_bild_titel
 * @property string $cms_bild_text
 * @property integer $cms_pos
 * @property integer $bilderverzeichnis_id
 * @property string $bild
 * @property integer $pos
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereCmsBilderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereCmsBilderverzeichnisId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereCmsBild($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereCmsBildTitel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereCmsBildText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereCmsPos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereBilderverzeichnisId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereBild($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder wherePos($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereUpdatedAt($value)
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder whereDeletedAt($value)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Bilder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Bilder newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Bilder query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Bilder withoutTrashed()
 */
class Bilder extends Model
{
    use SoftDeletes;

    protected $table = 'cms_bilder';
    protected $dates = ['deleted_at'];
}
