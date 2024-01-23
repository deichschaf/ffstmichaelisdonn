<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AdminController extends GroundController
{
    private static string $adminCookieToken = 'AdminUserCookie';
    private static int $adminCookieMaxTime = 10;

    public function showAdminPage(Request $request)
    {
        if (!$request->has('t')) {
            header('Location: /login', true, 403);
            exit();
        }
        $t = $request->get('t');
        return redirect('/admin')
            ->header('Authorization', 'Bearer ' . $t)
            ->header('Accept', 'application/json')
            ->with('messageSuccess', 'Login successful');
    }

    public function setAdminCookie()
    {
        Cookie::make(self::$adminCookieToken, self::getUserIpAddress(), self::$adminCookieMaxTime);
        return redirect('/login');
    }

    /**
     * @return string
     */
    private function getUserIpAddress(): string
    {
        if (!array_key_exists('REMOTE_ADDR', $_SERVER)) {
            die();
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    public function checkAdminCookie()
    {
        if (Cookie::has(self::$adminCookieToken)) {
        }
    }

    public function removeAdminCookie()
    {
        return redirect('/login');
    }
}
