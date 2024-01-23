<?php

namespace App\Http\Traits;

use App\Http\Models\ToDo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait TodoTrait
{
    /**
     * @return array
     */
    public function getToDoStatistic(): array
    {
        $data = Cache::remember(
            __CLASS__ . '_' . __FUNCTION__,
            Config::get('CacheConfig.cache_content_timeout'),
            function () {
                $data = [];
                $countToDos = ToDo::orderBy('id', 'ASC')->count();
                $countToDosOpen = ToDo::where('status_id', '!=', '5')->count();
                $data['title'] = 'Offene Todos';
                $data['count'] = $countToDosOpen;
                $data['count_comma'] = number_format($countToDosOpen);
                $data['count_max'] = $countToDos;
                $data['percent'] = $this->getPercentage($countToDos, $countToDosOpen);
                return $data;
            }
        );
        return $data;
    }

    /**
     * @param int $count
     * @return array
     */
    public function getLastOpenToDoStatistic(int $count = 3): array
    {
        $data = [];
        $OpenToDos = ToDo::where('status_id', '!=', '5')->orderBy('id', 'DESC')->take($count)->get();
        $OpenToDos->each(function ($td) use (&$data) {
            $data[] = [
                'headline' => $td->todotitle,
                'description' => $td->tododescription,
                'type' => 'info',
                'date' => $this->getDatumZeit($td->created_at)
            ];
        });
        return $data;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function setToDoStore(Request $request): JsonResponse
    {
        try {
            $inputs = $request->all();
            if (is_numeric($inputs['_id']) && $inputs['_id'] > 0) {
                $save = ToDo::find($inputs['_id']);
            } else {
                $save = new ToDo();
            }
            $save->todotitle = $this->checkText($inputs['todotitle']);
            $save->tododescription = $this->checkText($inputs['tododescription']);
            $save->parent_id = $this->checkText($inputs['parent_id']);
            $save->todo_area_id = $this->checkText($inputs['todo_area_id']);
            $save->status_id = $this->checkText($inputs['status_id']);
            $save->type_id = $this->checkText($inputs['type_id']);
            $save->save();
            return [];
        } catch (Exception $exception) {
            return $this->makeJsonLogging(
                __CLASS__,
                __FUNCTION__,
                __LINE__,
                $exception->getCode(),
                $exception->getMessage(),
                0
            );
        }
    }
}
