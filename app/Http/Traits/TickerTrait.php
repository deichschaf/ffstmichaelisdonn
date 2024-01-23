<?php

namespace App\Http\Traits;

/**
 * Trait TickerTrait
 * @package App\Http\Traits
 */
trait TickerTrait
{
    /**
     * @param $title
     * @return string
     */
    public function showTicker($title)
    {
        $data = [];
        $data['ticker'] = '';

        return view('widget.ticker')->with('data', $data)->render();
    }
}
