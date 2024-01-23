<?php

namespace App\Http\Controllers;

use App\Http\Models\Spam;

class SpamController extends GroundController
{
    public function getSpam($mysql)
    {
        $spam = array();
        $Spam = Spam::get();
        $Spam->each(function ($s) use (&$spam) {
            $spam[] = $s->spam;
        });
        return $spam;
    }
}
