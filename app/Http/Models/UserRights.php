<?php

namespace App\Http\Models;

trait UserRights
{
    public function checkright($area, $action, $user_id = SESSION::id, $return = 'login')
    {
        /**
         * @todo Check ob Admin oder User
         */
        $Rights = UserRights::where('area', '=', $area)->where('action', '=', '1')->where('user_id', '=', $user_id)->get();
        $Rights->each(function ($rights) {
            if ($right === 0) {
                return Route::to($return);
            }
            return true;
        });
    }
}
