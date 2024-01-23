<?php

namespace App\Http\Traits;

use App\Http\Models\News;
use Illuminate\Support\Facades\Session;

trait SocialMediaTrait
{
    /***
     * @todo Check other Websites for this
     * @param $txt
     * @return mixed
     */
    public static function getStaticFacebookDescription($txt)
    {
        return $txt;
    }
}
