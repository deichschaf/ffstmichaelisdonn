<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Contracts\Foundation\Application;

/**
 * CMSCacheMiddleware
 * Just redirects to next closure, but will clear Laravel cache in sandbox environments
 *
 * @param request The request object.
 * @param $next The next closure.
 * @return redirects to the secure counterpart of the requested uri.
 */
class CMSCacheMiddleware
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle($request, Closure $next)
    {
        if (env('APP_ENV') === 'sandbox') {
            $this->CMSRemoveCache();
        }
        return $next($request);
    }

    public static function CMSRemoveCache()
    {
        $cachedViewsDirectory = app('path.storage') . '/framework/views/';
        $files = glob($cachedViewsDirectory . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
    }
}
