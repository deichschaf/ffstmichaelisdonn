<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Http\Models\Ticker;
use App\Http\Models\UserLogin;
use App\Http\Models\Layout;
use App\Http\Models\User;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\FxToolsTrait;
use Illuminate\Contracts\Mail;
use Illuminate\Http\Request;
use Auth;

/**
 * Class TickerController
 * @package App\Http\Controllers
 */
class TickerController extends GroundController
{
    /**
     * @return string
     */
    public function adminShow()
    {
        $data = [];
        $Ticker = \App\Http\Models\Ticker::all();
        $ticker = [];
        $Ticker->each(function ($t) use (&$ticker) {
            $ticker[$t->id] = [
                'id' => $t->id,
                'ticker' => $t->ticker,
                'ticker_start' => $t->ticker_start,
                'ticker_ende' => $t->ticker_ende,
                'aktiv' => $t->aktiv,
            ];
        });
        $data['ticker'] = $ticker;
        $content =  view('ticker.overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @return string
     */
    public function adminAdd()
    {
        $data = [];
        $data['id'] = '';
        $data['ticker'] = '';
        $data['ticker_start'] = '';
        $data['ticker_ende'] = '';
        $data['aktiv'] = '';
        $content =  view('ticker.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @param $id
     * @return string
     */
    public function adminEdit($id)
    {
        $data = [];
        $Ticker = \App\Http\Models\Ticker::where('id', '=', $id)->get();
        $ticker = [];
        $Ticker->each(function ($t) use (&$data) {
            $data['id'] = $t->id;
            $data['ticker'] = $t->ticker;
            $data['ticker_start'] = $t->ticker_start;
            $data['ticker_ende'] = $t->ticker_ende;
            $data['aktiv'] = $t->aktiv;
        });
        $content =  view('ticker.add_edit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, '', false, false);
    }

    /**
     * @param $id
     */
    public function adminDelete($id)
    {
    }

    /**
     *
     */
    public function adminDeletePost()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminSave(Request $request)
    {
        $inputs = $request->all();
        if ($inputs['id'] !== 0) {
            $update = Ticker::find($inputs['id']);
            $update->ticker = FxToolsTrait::checkChar($inputs['ticker']);
            $update->ticker_start = FxToolsTrait::checkChar($inputs['ticker_start']);
            $update->ticker_ende = FxToolsTrait::checkChar($inputs['ticker_ende']);
            $update->aktiv = FxToolsTrait::checkChar($inputs['aktiv']);
            $update->save();
        } else {
            $add = new Ticker();
            $add->ticker = FxToolsTrait::checkChar($inputs['ticker']);
            $add->ticker_start = FxToolsTrait::checkChar($inputs['ticker_start']);
            $add->ticker_ende = FxToolsTrait::checkChar($inputs['ticker_ende']);
            $add->aktiv = FxToolsTrait::checkChar($inputs['aktiv']);
            $add->save();
        }
        return redirect()->route('admin.ticker');
    }
}
