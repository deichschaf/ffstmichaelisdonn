<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait IntranetTrait
{
    private static function checkRights()
    {
        /**
         * If UserGroup === Administrator
         * Bei allen Rechten auf 1 setzen
         */
    }

    private static function getMyGroups()
    {
    }

    private static function getUserGroups()
    {
    }

    /**
     * Hole alle Dateien, die für die Gruppe freigegeben sind
     * @param $area
     * @param $class
     * @param $folder
     * @param $group
     */
    private static function getFilesByGroup($area, $class, $folder, $group)
    {
    }

    /**
     * Zeige alle Ordner an
     * @param string $page
     * @param string $ordner
     * @param string $bereich
     * @param object $mysql
     */
    private static function getFileList($page, $folder, $area)
    {
    }

    public static function addFolder()
    {
    }

    public static function deleteFolder()
    {
    }

    public static function editFolder()
    {
    }

    public static function moveFolder()
    {
    }

    public static function addFile()
    {
    }

    public static function deleteFile()
    {
    }

    public static function editFile()
    {
    }
    private static function uploadFile()
    {
    }

    public static function moveFile()
    {
    }

    private static function addFolderGroupRights()
    {
    }

    public static function editFolderGroupRights()
    {
    }

    public static function updateFolderGroupRights()
    {
    }

    private static function addFileGroupRights()
    {
    }

    public static function editFileGroupRights()
    {
    }

    public static function updateFileGroupRights()
    {
    }
}
