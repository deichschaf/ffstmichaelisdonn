<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\Admin
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $mitglied_id
 * @property string $activated
 * @property string $deaktiv
 * @property string $admin
 * @property string $superadmin
 * @property string $name
 * @property string $nachname
 * @property string $vorname
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $lastlogin
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereMitgliedId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereActivated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereDeaktiv($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereSuperadmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereNachname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereVorname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereLastlogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereUpdatedAt($value)
 * @property string $must_change_pw
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereMustChangePw($value)
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin whereDeletedAt($value)
 * @property string|null $email_verified_at
 * @property string $is_admin
 * @property string|null $last_login_at
 * @property string|null $last_login_ip
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Admin newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Admin query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Admin whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Admin whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\Admin whereLastLoginIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\Admin withoutTrashed()
 */
class Admin extends Model
{
    use SoftDeletes;

    protected $table = 'users';
    protected $dates = ['deleted_at'];
}
