<?php

namespace App\Http\Traits;

/**
 * Trait FxToolsCacheTrait
 * @package App\Http\Traits
 */
trait FxToolsCacheTrait
{
    /**
     * @param $content
     * @param $cacheFile
     */
    public function createCache($content, $cacheFile)
    {
        $content = trim($content);
        $fp = fopen($cacheFile, 'w');
        fwrite($fp, $content);
        fclose($fp);
    }

    /**
     * @param $cacheFile
     * @param $expireTime
     * @return false|string
     */
    public function getCache($cacheFile, $expireTime)
    {
        if (file_exists($cacheFile) && filemtime($cacheFile) > (time() - $expireTime)) {
            return file_get_contents($cacheFile);
        }

        return false;
    }

    /**
     * Verwendung ab hier mit der aktuellen CMS Version.
     */

    /**
     * Öffnet von der Aktuellen Seite die gecachte Seite, ansonsten übergibt er den aktuellen Namen.
     *
     * @param array $http
     *
     * @return string
     */
    public function openCache($http)
    {
        $file = '';
        if (
            '' == $http->Request('action')
            &&
            '' == $http->Request('gaestebuch')
            &&
            'mitglieder' != $http->Request('page')
        ) {
            $page = 'home';
            if ('' != $http->Request('page')) {
                $page = $http->Request('page');
            }
            $link = $page;
            if ('' != $http->Request('view')) {
                $link .= '_view_' . $http->Request('view');
            }
            if ('' != $http->Request('show')) {
                $link .= '_show_' . $http->Request('show');
            }
            $file = PAGECACHE . $link . '.htm';
            $CacheDauer = 3600;
            if (file_exists($file) && (time() - filemtime($file)) < $CacheDauer) {
                include $file;
                exit();
            }
            $del = $this->deleteCache();
        }

        return $file;
    }

    /**
     * Schreibt die aktuelle Seite in die Cachedatei.
     *
     * @param sting $file
     * @param sting $content
     */
    public function writeCache($file, $content)
    {
        if ('' != $file) {
            $datei = fopen($file, 'w');
            fwrite($datei, $content);
            fclose($datei);
        }
    }

    /**
     *
     */
    public function deleteCache()
    {
        $verzeichnis = opendir(PAGECACHE);
        while ($file = readdir($verzeichnis)) {
            if ('.' != $file && '..' != $file) {
                unlink(PAGECACHE . $file);
            }
        }
        closedir($verzeichnis);
    }
}
