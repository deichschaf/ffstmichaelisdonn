<?php

namespace App\Http\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Http\Models\SeitenTexte
 *
 * @mixin Eloquent
 * @method static bool|null forceDelete()
 * @method static Builder|SeitenTexte newModelQuery()
 * @method static Builder|SeitenTexte newQuery()
 * @method static \Illuminate\Database\Query\Builder|SeitenTexte onlyTrashed()
 * @method static Builder|SeitenTexte query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|SeitenTexte withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SeitenTexte withoutTrashed()
 * @property int $id
 * @property string|null $placeholder_name
 * @property string|null $placeholder_text
 * @property Carbon|null $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|SeitenTexte whereCreatedAt($value)
 * @method static Builder|SeitenTexte whereDeletedAt($value)
 * @method static Builder|SeitenTexte whereId($value)
 * @method static Builder|SeitenTexte wherePlaceholderName($value)
 * @method static Builder|SeitenTexte wherePlaceholderText($value)
 * @method static Builder|SeitenTexte whereUpdatedAt($value)
 */
class SeitenTexte extends Model
{
    use SoftDeletes;

    protected $table = 'cms_seiten_texte';
    protected $dates = ['deleted_at'];
}
