<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\FxToolsTrait;
use App\Http\Traits\HeaderTrait;
use App\Http\Traits\MetatagsTrait;
use App\Http\Traits\LayoutTrait;
use App\Http\Traits\NavigationTrait;
use App\Http\Traits\NewsTrait;
use App\Http\Traits\WidgetTrait;

/**
 * App\Http\Models\Layout
 *
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Layout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Layout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Layout query()
 */
class Layout extends Model
{
    use FxToolsTrait;
    use HeaderTrait;
    use MetatagsTrait;
    use LayoutTrait;
    use NavigationTrait;
    use NewsTrait;
    use WidgetTrait ;
}
