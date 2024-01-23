<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\CacheModel
 *
 * @property string $key
 * @property string $value
 * @property int $expiration
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder|CacheModel newModelQuery()
 * @method static Builder|CacheModel newQuery()
 * @method static Builder|CacheModel query()
 * @method static Builder|CacheModel whereCreatedAt($value)
 * @method static Builder|CacheModel whereDeletedAt($value)
 * @method static Builder|CacheModel whereExpiration($value)
 * @method static Builder|CacheModel whereKey($value)
 * @method static Builder|CacheModel whereUpdatedAt($value)
 * @method static Builder|CacheModel whereValue($value)
 * @mixin Eloquent
 */
class CacheModel extends Model
{
    protected $table = 'cache';
}
