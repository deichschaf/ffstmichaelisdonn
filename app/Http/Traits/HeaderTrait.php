<?php

namespace App\Http\Traits;

trait HeaderTrait
{
    public function getHeader($title)
    {
        $data = [];
        $data['metatag'] = $this->buildMetatag($title, false);
        $data['title'] = env('HOMEPAGETITEL', '???? Homepagetitel ???') . ' - ' . $title;

        return view('layout.header')->with('data', $data)->render();
    }
}
