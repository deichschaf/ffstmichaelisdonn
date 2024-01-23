<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Partner
 *
 * @property int $id
 * @property string $partner
 * @property string $partner_logo
 * @property string $partner_start
 * @property string $partner_ende
 * @property string $partner_link
 * @property int $pos
 * @property string $aktiv
 * @property string $show_partner_name
 * @property string $erstellt_am
 * @property string $erstellt_von
 * @property string $geaendert_am
 * @property string $geaendert_von
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner newQuery()
 * @method static \Illuminate\Database\Query\Builder|Partner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereAktiv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereErstelltAm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereErstelltVon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereGeaendertAm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereGeaendertVon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner wherePartner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner wherePartnerEnde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner wherePartnerLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner wherePartnerLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner wherePartnerStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereShowPartnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Partner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Partner withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Partner withoutTrashed()
 * @mixin \Eloquent
 */
class Partner extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_partner';
}
