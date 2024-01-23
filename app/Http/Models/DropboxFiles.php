<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\DropboxFiles
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DropboxFiles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DropboxFiles newQuery()
 * @method static \Illuminate\Database\Query\Builder|DropboxFiles onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DropboxFiles query()
 * @method static \Illuminate\Database\Query\Builder|DropboxFiles withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DropboxFiles withoutTrashed()
 * @mixin \Eloquent
 */
class DropboxFiles extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_dropbox_files';
}
