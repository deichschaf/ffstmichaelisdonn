<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Route;

class HTMLminify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Route::currentRoutename() !== 'intern.api.termine') {
            /*if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
                ob_start("ob_gzhandler");
            }else{
                ob_start();
            }
            */
            header("X-Compression: gzip");
            header("Content-Encoding: gzip");

            $response = $next($request);
            $content = $response->getContent();
            $search = array(
                '/\[^\S]+/s', // strip whitespaces after tags, except space
                '/[^\S]+\</s', // strip whitespaces before tags, except spaces
                '/(\s)+/s' // shorten multiple whitespace sequences
            );
            $replace = array(
                '>',
                '<',
                '\\1'
            );
            $buffer = preg_replace($search, $replace, $content);
            return $response->setContent($buffer);
        }
        return $request;
    }
}
