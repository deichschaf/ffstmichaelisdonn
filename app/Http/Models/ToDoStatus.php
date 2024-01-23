<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\ToDoStatus
 *
 * @property int $id
 * @property string $status
 * @property string $status_readable
 * @property int $pos
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoStatus newQuery()
 * @method static \Illuminate\Database\Query\Builder|ToDoStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoStatus wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoStatus whereStatusReadable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ToDoStatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ToDoStatus withoutTrashed()
 * @mixin \Eloquent
 */
class ToDoStatus extends Model
{
    use SoftDeletes;

    protected $table = 'cms_todo_status';
    protected $dates = ['deleted_at'];
}
