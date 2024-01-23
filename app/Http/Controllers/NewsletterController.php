<?php

namespace App\Http\Controllers;

use App\Http\Models\News;
use App\Http\Models\Layout;
use App\Http\Traits\NewsletterTrait;

class NewsletterController extends GroundController
{
    /**
     *
     */
    public function newsShow()
    {
        $data = array();
        $data['title'] = 'Newsletter';
        $data['newsletter'] = NewsletterTrait::getAllNewsletter();
        $content = view('intern.newsletter')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_content($content, $data['title'], false, false);
    }

    /**
     * Newsletter anmelden
     */
    public function add()
    {
    }

    /**
     * Newsletteranmeldung bestätigen
     */
    public function addok()
    {
    }

    /**
     * Newsletter abmelden
     */
    public function remove()
    {
    }

    /**
     * @param $id
     */
    public function read_newsletter($id)
    {
        return view('intern.newsletter_showcontent')->render();
    }

    public function adminShow()
    {
        $data = array();
        $data['title'] = 'ADMIN Newsletter';
        $data['newsletter'] = NewsletterTrait::getAllNewsletter();
        $content = view('intern.admin_newsletter_overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    public function adminAdd()
    {
    }

    public function adminEdit($id)
    {
    }

    public function adminDelete($id)
    {
    }

    public function adminDeletePost()
    {
    }

    public function adminSave()
    {
    }
}
