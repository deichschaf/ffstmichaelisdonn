<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\DropboxSyncLog
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DropboxSyncLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DropboxSyncLog newQuery()
 * @method static Builder|DropboxSyncLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DropboxSyncLog query()
 * @method static Builder|DropboxSyncLog withTrashed()
 * @method static Builder|DropboxSyncLog withoutTrashed()
 * @mixin Eloquent
 */
class DropboxSyncLog extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_dropbox_sync_log';
}
