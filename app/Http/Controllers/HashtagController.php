<?php

namespace App\Http\Controllers;

use App\Http\Models\Hashtag;
use Illuminate\Http\Request;

class HashtagController extends GroundController
{
    public function makeHashtag($txt)
    {
    }

    private function getHashtag()
    {
        $hashtags = array();
        $Hashtag = Hashtag::get();
        $Hashtag->each(
            function ($hash) use (&$hashtags) {
                $hashtags[] = $hash['hashtag'];
            }
        );
        return $hashtags;
    }

    public function build_hashtag($text)
    {
        if (strlen($text) === 0) {
            return '';
        }
        $hashtags = $this->getHashtag();
        if (count($hashtags) === 0) {
            return '';
        }
        $tmp = array();
        foreach ($hashtags as $hash) {
            //matches will be terms exactly as in database,
            //followed by space or newline
            $tmp[] = "/($hash)(\s|$)/i";
        }

        $text = $this->replace_content($text);

        $out = preg_replace($tmp, '#$0', $text);
        return $out;
    }

    public function addHashtag(Request $request)
    {
        $input = $request->get('value');
        $terms = $this->getHashtag();
        //get terms from subject string
        $tmp = array();
        $new_terms = array();
        preg_match_all('/#\w+(\s|$)/', $input, $tmp);
        foreach ($tmp[0] as $term) {
            $new_terms[] = trim(strtolower(str_replace('#', '', $term)));
        }
        $tmp = array_diff($new_terms, $terms);
        if (count($tmp) > 0) {
            foreach ($tmp as $k => $val) {
                $Hash = Hashtag::create($val);
            }
        }
    }

    /**
     * Replace Hashtags with Right StringType
     */
    private function getHashReplace()
    {
        $hashtags = array();
        $Hashtag = Hashtag::where('hash_replace', '!=', '')->get();
        $Hashtag->each(function ($hash) use (&$hashtags) {
            $hashtags[] = $hash->hash_replace;
        });
        return $hashtags;
    }

    private function replace_content($txt)
    {
        $hashtags = $this->getHashReplace();
        $txt = preg_replace($hashtags, '$0', $txt);
        return $txt;
    }
}
