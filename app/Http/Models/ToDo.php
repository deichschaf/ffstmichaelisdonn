<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\ToDo
 *
 * @property int $id
 * @property int $todo_area_id
 * @property int $parent_id
 * @property string|null $todotitle
 * @property string|null $tododescription
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\ToDo onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo whereTodoAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo whereTododescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo whereTodotitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Http\Models\ToDo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\ToDo withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Http\Models\ToDo withoutTrashed()
 * @mixin \Eloquent
 * @property int|null $status_id
 * @property int|null $type_id
 * @property string $todo_type
 * @method static \Illuminate\Database\Eloquent\Builder|ToDo whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDo whereTodoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ToDo whereTypeId($value)
 */
class ToDo extends Model
{
    use SoftDeletes;

    protected $table = 'cms_todo';
    protected $dates = ['deleted_at'];
}
