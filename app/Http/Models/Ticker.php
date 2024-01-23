<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\Ticker
 *
 * @mixin Eloquent
 * @property integer $id
 * @property string $datum
 * @property string $ticker
 * @property string $ticker_start
 * @property string $ticker_ende
 * @property string $ticker_link
 * @property string $aktiv
 * @property string $erstellt_am
 * @property string $erstellt_von
 * @property string $geaendert_am
 * @property string $geaendert_von
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static Builder|Ticker whereId($value)
 * @method static Builder|Ticker whereDatum($value)
 * @method static Builder|Ticker whereTicker($value)
 * @method static Builder|Ticker whereTickerStart($value)
 * @method static Builder|Ticker whereTickerEnde($value)
 * @method static Builder|Ticker whereTickerLink($value)
 * @method static Builder|Ticker whereAktiv($value)
 * @method static Builder|Ticker whereErstelltAm($value)
 * @method static Builder|Ticker whereErstelltVon($value)
 * @method static Builder|Ticker whereGeaendertAm($value)
 * @method static Builder|Ticker whereGeaendertVon($value)
 * @method static Builder|Ticker whereCreatedAt($value)
 * @method static Builder|Ticker whereUpdatedAt($value)
 * @property Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticker newQuery()
 * @method static Builder|Ticker onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticker query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticker whereCmsTickerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticker whereDeletedAt($value)
 * @method static Builder|Ticker withTrashed()
 * @method static Builder|Ticker withoutTrashed()
 */
class Ticker extends Model
{
    use SoftDeletes;

    protected $table = 'cms_ticker';
    protected $dates = ['deleted_at'];
}
