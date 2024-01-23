<?php

namespace App\Http\Traits;

use App\Http\Models\Feuerwehren;

trait WehrenTrait
{
    public static function getStaticAll()
    {
        $data = array();
        $Einheiten = Feuerwehren::orderBy('einheit', 'ASC')->get();
    }
    public static function getStaticData($id)
    {
    }
    public static function delete($id)
    {
    }
}
