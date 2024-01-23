<?php

namespace App\Http\Controllers;

use App\Http\Models\Changelog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class ChangeLogController extends GroundController
{
    public function changelogOverviewApi(): JsonResponse
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_navi_timeout'),
            function () {
                $data = [];
                $data['changelog'] = $this->getListChangeLog();
                $data['form_add_url'] = $this->getAdminPath().'/changelog/add';
                $data['form_edit_url'] = $this->getAdminPath().'/changelog/edit';
                $data['form_delete_url'] = $this->getAdminPath().'/changelog/delete';
                $data['form_save_url'] = '/api'.$this->getAdminPath().'/changelog/save';
                return $data;
            }
        );
        return response()->json($data, 200);
    }

    public function getData($id, Request $request): JsonResponse
    {
        $changelog = [];
        $ChangeLog = Changelog::where('id', '=', $id)->get();
        $ChangeLog->each(function ($cl) use (&$changelog) {
            $changelog = [
                'release' => $cl->release,
                'title' => $cl->release,
                'datum' => $this->getDatumDe($cl->datum),
                'date' => $this->getDatumDe($cl->datum),
                'tasks' => $this->getLastChangeLogDetailsEdit($cl->id),
                'description' => $this->getLastChangeLogDetailsEdit($cl->id),
            ];
        });

        return response()->json($changelog, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @todo build save function
     */
    public function saveData(Request $request): JsonResponse
    {
        $data = [];
        return response()->json($data, 200);
    }

    public function adminOverview(): JsonResponse
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_navi_timeout'),
            function () {
                $data = [];
                $data['saison'] = $this->getListChangeLog();
                $data['form_add_url'] = '/changelog/add';
                $data['form_edit_url'] = '/changelog/edit';
                $data['form_delete_url'] = '/changelog/delete';
                return $data;
            }
        );
        return response()->json($data, 200);
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

    public function adminStore()
    {
        $this->cleanPageData();
    }
}
