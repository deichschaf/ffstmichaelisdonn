<?php

namespace App\Http\Controllers;

use App\Http\Models\Layout;
use App\Http\Traits\PageTrait;
use App\Http\Traits\TelLexikonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Support\Facades\Session;

class SearchController extends GroundController
{
    public function searchShow(Request $request)
    {
        $content = [];
        $inputs = $request->all();

        if (empty($inputs['search'])) {
            return redirect()->back('301');
        }

        $validator = Validator::make($inputs, [
            'search' => 'required|alphaNum|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back('301')
                ->withErrors($validator)
                ->withInput();
        }

        $search = $inputs['search'];

        if (session()->has(env('SESSION_ONLY_USER'))) {
            $content = $this->search_nopublic($search);
        } else {
            $content = $this->search_public($search);
        }
        $data = array();
        $data['content'] = $content;
        $data['searchword'] = explode(' ', $search);
        $content =  view('search.index')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, '', false, false);
    }

    public function autoresponse()
    {
    }

    private function searchPublic($search)
    {
        $content = [];
        $content = PageTrait::getSearchPage($search, 0, $content);
        $content = FahrzeugeTrait::getSearch($search, $content);
        $content = EinsaetzeTrait::getSearch($search, $content);
        $content = TelLexikonTrait::getSearch($search, $content);
        $content = LinksTrait::getSearch($search, $content);
        return $content;
    }

    private function searchNopublic($search)
    {
        $content = [];
        $content = PageTrait::getSearchPage($search, 1, $content);
        $content = FahrzeugeTrait::getSearch($search, $content);
        $content = EinsaetzeTrait::getSearch($search, $content);
        $content = TelLexikonTrait::getSearch($search, $content);
        $content = LinksTrait::getSearch($search, $content);
        return $content;
    }
}
