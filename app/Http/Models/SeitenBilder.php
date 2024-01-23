<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\SeitenTexte
 *
 * @mixin \Eloquent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SeitenBilder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SeitenBilder newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenBilder onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\SeitenBilder query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenBilder withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\SeitenBilder withoutTrashed()
 * @property int $id
 * @property int $page_id
 * @property string $bild
 * @property string $titel
 * @property int $pos
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenBilder whereBild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenBilder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenBilder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenBilder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenBilder wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenBilder wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenBilder whereTitel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeitenBilder whereUpdatedAt($value)
 */
class SeitenBilder extends Model
{
    use SoftDeletes;

    protected $table = 'cms_seiten_bilder';
    protected $dates = ['deleted_at'];
}
