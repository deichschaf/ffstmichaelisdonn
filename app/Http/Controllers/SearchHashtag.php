<?php

namespace App\Http\Controllers;

use App\Http\Models\Hashtag;

class SearchHashtag
{
    public function search($hashtag)
    {
        $result = array();
        $result['facebook'] = $this->searchFacebook($hashtag);
        $result['twitter'] = $this->searchTwitter($hashtag);

        return $result;
    }

    private function searchFacebook($hashtag)
    {
    }

    private function searchTwitter($hashtag)
    {
    }

    private function searchFlickr($hashtag)
    {
    }

    private function searchYoutube($hashtag)
    {
    }

    private function searchInstagram($hashtag)
    {
    }

    private function searchGooglePlus($hashtag)
    {
    }
}
