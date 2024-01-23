<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\LinksKategrorien.
 *
 * @method static Builder|LinksKategrorien newModelQuery()
 * @method static Builder|LinksKategrorien newQuery()
 * @method static \Illuminate\Database\Query\Builder|LinksKategrorien onlyTrashed()
 * @method static Builder|LinksKategrorien query()
 * @method static \Illuminate\Database\Query\Builder|LinksKategrorien withTrashed()
 * @method static \Illuminate\Database\Query\Builder|LinksKategrorien withoutTrashed()
 * @mixin Eloquent
 * @property int $id
 * @property string $link_kategorie
 * @property int $pos
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|LinksKategrorien whereCreatedAt($value)
 * @method static Builder|LinksKategrorien whereDeletedAt($value)
 * @method static Builder|LinksKategrorien whereId($value)
 * @method static Builder|LinksKategrorien whereLinkKategorie($value)
 * @method static Builder|LinksKategrorien wherePos($value)
 * @method static Builder|LinksKategrorien whereUpdatedAt($value)
 */
class LinksKategrorien extends Model
{
    use SoftDeletes;

    protected $table = 'cms_links_kategorien';
    protected $dates = ['deleted_at'];
}
