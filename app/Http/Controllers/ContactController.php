<?php

namespace App\Http\Controllers;

use App\Http\Mail\Contactform;
use App\Http\Models\Kontakt;
use App\Http\Models\Layout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

/**
 * Class ContactController
 * @package App\Http\Controllers
 */
class ContactController extends GroundController
{
    /**
     * @return string
     */
    public function contact()
    {
        $data = [];
        $data['title'] = 'Kontakt';
        $content = view('kontakt.kontakt')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function contact_send(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'vorname' => 'required|alpha',
            'name' => 'required|alpha',
            'strasse' => 'required|alpha',
            'hausno' => 'required|alpha',
            'message' => 'required|alphaNum',
            'telefon' => 'required|numeric',
            'plz' => 'required|Numeric',
            'ort' => 'required|alpha',
            'email' => 'required|email',
        ]);

        $data['datum_zeit'] = date('Y-m-d H:i:s');
        $datetime = explode(' ', $data['datum_zeit']);
        $data['empfaenger'] = 'Jörg-Marten Hoffmann';
        $data['empfaenger_email'] = 'info@ff-st-michel.de';
        $data['datum'] = $datetime['0'];
        $date = explode('-', $datetime['0']);
        $data['datum_de'] = $date['2'] . '.' . $date['1'] . '.' . $date['0'];
        $data['zeit'] = $datetime['1'];
        $save = new Kontakt();
        $save->datum = $datetime['0'];
        $save->zeit = $datetime['1'];
        $save->name = $data['vorname'] . ' ' . $data['name'];
        $save->anschrift = $data['strasse'] . ' ' . $data['hausno'];
        $save->ort = $data['plz'] . ' ' . $data['ort'];
        $save->telefon = $data['telefon'];
        $save->emailadresse = $data['email'];
        $save->nachricht = $data['message'];
        $save->save();

        $mailer = new Contactform($data);
        $mailer->replyTo($data['email']);
        Mail::to('info@ff-stmichaelisdonn.de')
            ->send($mailer);

        $data = [];
        $data['title'] = 'Kontakt';
        //$content =  view('kontakt.kontakt')->with('data', $data)->render();
        $content = '';
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }
}
