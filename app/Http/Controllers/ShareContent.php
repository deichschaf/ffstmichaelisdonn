<?php

namespace App\Http\Controllers;

use App\Http\Models\Share;

class ShareContent
{
    public function ShareFacebook($title, $content)
    {
        $url = "";
        $user = false;
        $password = false;


        return $this->Share($url, $user, $password);
    }

    public function ShareTwitter($content)
    {
    }

    public function ShareFlickr($title, $content)
    {
    }

    public function ShareGooglePlus($title, $content)
    {
    }

    public function ShareYouTube($title, $content)
    {
    }

    public function ShareInstagram($content)
    {
    }

    private function Share($url, $user = false, $password = false)
    {
        $tools = new Tools();
        $content = $tools-> ReadOtherContent($url, $user, $password);
        return $content;
    }
}
