<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Http\Models\DropboxISOFiles
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DropboxISOFiles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DropboxISOFiles newQuery()
 * @method static \Illuminate\Database\Query\Builder|DropboxISOFiles onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DropboxISOFiles query()
 * @method static \Illuminate\Database\Query\Builder|DropboxISOFiles withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DropboxISOFiles withoutTrashed()
 * @mixin \Eloquent
 */
class DropboxISOFiles extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_dropbox_isos_files';
}
