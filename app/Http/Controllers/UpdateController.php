<?php

namespace App\Http\Controllers;

use App\Http\Models\User;

class UpdateController extends GroundController
{
    public function update()
    {
        $this->make_user_hash();
        echo 'Fertig!';
    }

    private function make_user_hash()
    {
        $user = User::all();
        foreach ($user as $k => $v) {
            $hash = md5($v->vorname . $v->nachname . rand(9999, 999999999999));
            $update = User::find($v->id);
            $update->hash =  $hash;
            $update->save();
        }
    }
}
