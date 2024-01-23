<?php

namespace App\Http\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Http\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $vorname
 * @property string|null $nachname
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string $is_admin
 * @property string $superadmin
 * @property string $deaktiv
 * @property string|null $last_login_at
 * @property string|null $last_login_ip
 * @property string|null $lastlogin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereDeaktiv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereLastlogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereNachname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereSuperadmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\User whereVorname($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
