<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Links
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $link_kategorie_id
 * @property string $link
 * @property string $link_text
 * @property integer $link_count
 * @property string $link_datum
 * @property string $link_titel
 * @property string $link_download
 * @property string $erstellt_am
 * @property string $erstellt_von
 * @property string $geaendert_von
 * @property string $geaendert_am
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereLinkKategorieId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereLink($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereLinkText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereLinkCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereLinkDatum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereLinkTitel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereLinkDownload($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereIsDelete($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereErstelltAm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereErstelltVon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereGeaendertVon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereGeaendertAm($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Links newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Links newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Links query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Links whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Links whereLinkId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Links withoutTrashed()
 */
class Links extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_links';
}
