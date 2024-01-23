<?php

namespace App\Http\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\AdminUserArea
 *
 * @mixin Eloquent
 * @property integer $id
 * @property integer $cms_admin_id
 * @property integer $cms_admin_bereiche_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|AdminUserArea whereId($value)
 * @method static Builder|AdminUserArea whereCmsAdminId($value)
 * @method static Builder|AdminUserArea whereCmsAdminBereicheId($value)
 * @method static Builder|AdminUserArea whereCreatedAt($value)
 * @method static Builder|AdminUserArea whereUpdatedAt($value)
 * @property Carbon $deleted_at
 * @method static Builder|AdminUserArea whereDeletedAt($value)
 * @property int $cms_admin_bereiche_zuordnung_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserArea newQuery()
 * @method static Builder|AdminUserArea onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserArea query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserArea whereCmsAdminBereicheZuordnungId($value)
 * @method static Builder|AdminUserArea withTrashed()
 * @method static Builder|AdminUserArea withoutTrashed()
 */
class AdminUserArea extends Model
{
    use SoftDeletes;

    protected $table = 'cms_admin_bereiche_zuordnung';
    protected $dates = ['deleted_at'];
}
