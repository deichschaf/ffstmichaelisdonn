<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\ToDoType
 *
 * @property int $id
 * @property string $todo_type
 * @property string $todo_type_readable
 * @property string|null $type_color
 * @property string $fa_type
 * @property string $icon
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType newQuery()
 * @method static Builder|ToDoType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType whereFaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType whereTodoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType whereTodoTypeReadable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType whereTypeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDoType whereUpdatedAt($value)
 * @method static Builder|ToDoType withTrashed()
 * @method static Builder|ToDoType withoutTrashed()
 * @mixin Eloquent
 */
class ToDoType extends Model
{
    use SoftDeletes;

    protected $table = 'cms_todo_type';
    protected $dates = ['deleted_at'];
}
