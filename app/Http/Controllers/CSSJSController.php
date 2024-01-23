<?php

namespace App\Http\Controllers;

class CSSJSController extends GroundController
{
    private function getCSSFiles()
    {
        $files = array();
        $files[] = '/css/bootstrap.min.css';
        $files[] = '/css/font-awesome.min.css';
        $files[] = '/css/styles.css';
        return $files;
    }

    private function getJSFiles()
    {
        $files = array();
        return $files;
    }

    /**
     * Komprimiert die gesamten CSS zu einer CSS
     * Schnellere Ladezeit!!
     */
    public function css()
    {
        $files = $this->getCSSFiles();
        header('');
    }

    /**
     * Komprimiert die gesamten JS zu einer JS
     * Schnellere Ladezeit!!
     */
    public function js()
    {
        $files = $this->getJSFiles();
    }

    public function js_admin()
    {
    }
    public function css_admin()
    {
    }
}
