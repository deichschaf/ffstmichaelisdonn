<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Http\Models\TELLexikonFAQ
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TELLexikonFAQ newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TELLexikonFAQ newQuery()
 * @method static Builder|TELLexikonFAQ onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|TELLexikonFAQ query()
 * @method static Builder|TELLexikonFAQ withTrashed()
 * @method static Builder|TELLexikonFAQ withoutTrashed()
 * @mixin Eloquent
 */
class TELLexikonFAQ extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'cms_lexikon_faq';
}
