<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\AdminArea
 *
 * @mixin Eloquent
 * @property integer $id
 * @property string $cms_admin_bereich
 * @property string $laravel_route
 * @property string $cms_admin_bereich_modul
 * @property string $cms_admin_bereich_url
 * @property integer $cms_admin_bereich_pos
 * @property integer $cms_admin_bereich_parent_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|AdminArea whereId($value)
 * @method static Builder|AdminArea whereCmsAdminBereich($value)
 * @method static Builder|AdminArea whereLaravelRoute($value)
 * @method static Builder|AdminArea whereCmsAdminBereichModul($value)
 * @method static Builder|AdminArea whereCmsAdminBereichUrl($value)
 * @method static Builder|AdminArea whereCmsAdminBereichPos($value)
 * @method static Builder|AdminArea whereCmsAdminBereichParentId($value)
 * @method static Builder|AdminArea whereCreatedAt($value)
 * @method static Builder|AdminArea whereUpdatedAt($value)
 * @property Carbon $deleted_at
 * @method static Builder|AdminArea whereDeletedAt($value)
 * @property int $cms_admin_bereiche_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminArea newQuery()
 * @method static Builder|AdminArea onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminArea query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminArea whereCmsAdminBereicheId($value)
 * @method static Builder|AdminArea withTrashed()
 * @method static Builder|AdminArea withoutTrashed()
 */
class AdminArea extends Model
{
    use SoftDeletes;

    protected $table = 'cms_admin_bereiche';
    protected $dates = ['deleted_at'];
}
