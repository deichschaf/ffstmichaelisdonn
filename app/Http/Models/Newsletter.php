<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\Newsletter
 *
 * @property int $id
 * @property string $newsletter_datum
 * @property string $newsletter_titel
 * @property string $versendet
 * @property int $versendet_an
 * @property string $datei
 * @property string $datei_titel
 * @property string $datei2
 * @property string $datei2_titel
 * @property string $datei3
 * @property string $datei3_titel
 * @property string $datei4
 * @property string $datei4_titel
 * @property string $zustellbestaetigung
 * @property string $empfangsbestaetigung
 * @property string $lesebestaetigung
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter newQuery()
 * @method static Builder|Newsletter onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereDatei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereDatei2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereDatei2Titel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereDatei3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereDatei3Titel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereDatei4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereDatei4Titel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereDateiTitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereEmpfangsbestaetigung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereLesebestaetigung($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereNewsletterDatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereNewsletterTitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereVersendet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereVersendetAn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Newsletter whereZustellbestaetigung($value)
 * @method static Builder|Newsletter withTrashed()
 * @method static Builder|Newsletter withoutTrashed()
 * @mixin Eloquent
 */
class Newsletter extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_newsletter';
}
