<?php

namespace App\Http\Traits;

/**
 * Trait FxToolsSimpleBBCodeTrait
 * @package App\Http\Traits
 */
trait FxToolsSimpleBBCodeTrait
{
    /**
     * FxToolsSimpleBBCodeTrait constructor.
     */
    public function __construct()
    {
        //standard bbcodes hinzufügen
        $this->assign('\[b\](.*)\[/b\]', '<strong>$1</strong>');
        $this->assign('\[i\](.*)\[/i\]', '<em>$1</em>');
        $this->assign('\[u\](.*)\[/u\]', '<u>$1</u>');
        $this->assign('\(.*)\[/img\]', '"<img src=\"" . htmlentities(\'\\1\', ENT_COMPAT) . "\" border=\"0\">"', true);
        $this->assign('\[list\](?s)(.*)\[/list\]', '$this->handleListBBcode(\'\\1\')', true);
        $this->assign('\[youtube\](.*)\[/youtube\]', '$this->handleYoutubeBBcode(\'\\1\')', true);
    }

    /**
     * @param $content
     * @return array|mixed|string|string[]|null
     */
    public function parse($content)
    {
        if (! count($this->bbcodes)) {
            return $content;
        }
        foreach ($this->bbcodes as $bbcode) {
            while (preg_match('~' . $bbcode['find'] . '~U', $content)) {
                if (isset($bbcode['eval'])) {
                    $content = preg_replace('~' . $bbcode['find'] . '~Ue', $bbcode['eval'], $content);
                } else {
                    $content = preg_replace('~' . $bbcode['find'] . '~U', $bbcode['replace'], $content);
                }
            }
        }

        return $content;
    }

    /**
     * @param $find
     * @param $replace
     * @param false $eval
     */
    public function assign($find, $replace, $eval = false)
    {
        $pattern = ['find' => $find];
        $pattern[((true === $eval) ? 'eval' : 'replace')] = $replace;
        $this->bbcodes[] = $pattern;
    }

    /**
     * @param $url
     * @return string
     */
    public function handleYoutubeBBcode($url)
    {
        if ('http://' === substr($url, 0, 7)) {
            $stack = [];
            preg_match('~.*watch?v=(\w+)&.*~', $url, $stack);
            if (empty($stack[1])) {
                return '';
            }
            $watch = $stack[1]; //\w kann nur a-zA-Z0-9_. sein, kein risiko
        } else {
            $watch = preg_replace('~\W+~', '', $url);
            if (empty($watch)) {
                return '';
            }
        }
        $youtube = '<object width="425" height="344">' .
            '<param name="movie" value="http://www.youtube.com/v/' . $watch . '&hl=en&fs=1"></param>' .
            '<param name="allowFullScreen" value="true"></param>' .
            '<embed src="http://www.youtube.com/v/' . $watch . '&hl=en&fs=1" ' .
            'type="application/x-shockwave-flash" allowfullscreen="true" width="425" ' .
            'height="344"></embed>' .
            '</object>';

        return $youtube;
    }

    /**
     * @param $list
     * @return string
     */
    public function handleListBBcode($list)
    {
        $bbcode = '<ul>';
        foreach (explode(' ', $list) as $item) {
            if (empty($item)) {
                continue;
            }
            $bbcode .= '<li>' . $item . '</li>';
        }

        return $bbcode . '</ul>';
    }
}
