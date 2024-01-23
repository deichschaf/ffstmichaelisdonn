<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\ToDoArea
 *
 * @property int $id
 * @property string|null $todoarea
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDoArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDoArea newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\ToDoArea onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDoArea query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDoArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDoArea whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDoArea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDoArea whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDoArea whereTodoarea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDoArea whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\ToDoArea withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\ToDoArea withoutTrashed()
 * @mixin \Eloquent
 */
class ToDoArea extends Model
{
    use SoftDeletes;

    protected $table = 'cms_todo_area';
    protected $dates = ['deleted_at'];
}
